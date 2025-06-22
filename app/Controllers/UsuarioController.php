<?php

global $tabela; $tabela = 'usuarios';
global $sigla;  $sigla = 'usu';

class UsuarioController extends Actions
{
    public function LoginPage()
    {
        global $tabela;
        loadView('login', $tabela, [], false, false, false);
    } // ok

    public function Registro()
    {
        global $tabela;
        loadView('registro', $tabela, [], false, false, false);
    } // ok

    public function TelaResetarSenha()
    {
        global $tabela;
        loadView('resetar-senha', $tabela, [], false, false, false);
    } // ok

    public function Login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $baseDir = dirname(__FILE__);
            include $baseDir . "/../utils/Database.php";

            date_default_timezone_set('America/Sao_Paulo');

            $cpf = $_POST['cpf'];
            $senha = $_POST['senha'];

            $sql = selecionarDoBanco('usuarios', '*', 'usu_cpf_cnpj = :cpf', [':cpf' => $cpf]);
            $total = count($sql);

            if ($total > 0) {

                foreach ($sql as $value) {
                    $usuID = $value['usu_id'];
                    $usuEmail = $value['usu_email'];
                    $usuGrupo = $value['usu_grupo_id'];
                    $usuCpf = $value['usu_cpf_cnpj'];
                    $usuSenha = $value['usu_senha'];
                    $usuNome = $value['usu_nome'];
                    $usuNivel = $value['usu_nivel'];
                    $usuStatus = $value['usu_status'];
                    $usuErro = $value['usu_erro'];
                }

                if ($usuStatus == 2) {
                    $data = ['resultado' => 'aguardando', 'msg' => 'Atenção!'];
                    header('Content-type: application/json');
                    echo json_encode($data);
                    return false;
                }

                if ($usuStatus == 3) {
                    $data = ['resultado' => 'reprovado', 'msg' => 'Atenção!'];
                    header('Content-type: application/json');
                    echo json_encode($data);
                    return false;
                }

                if ($usuStatus == 4) {
                    $data = ['resultado' => 'bloqueado', 'msg' => 'Atenção!'];
                    header('Content-type: application/json');
                    echo json_encode($data);
                    return false;
                } else {

                    if (password_verify($senha, $usuSenha)) {

                        // Gerar token único para a sessão
                        $token = bin2hex(random_bytes(32));
                        $_SESSION['user_id'] = $usuID;
                        $_SESSION['token'] = $token;

                        // Remover sessões anteriores e armazenar nova sessão
                        $stmt = $pdo->prepare("REPLACE INTO user_sessions (user_id, session_token) VALUES (?, ?)");
                        $stmt->execute([$usuID, $token]);

                        //criptografia dos cookies
                        $cookies = [
                            "id" => $usuID,
                            "grupo" => $usuGrupo,
                            "cpf" => $usuCpf,
                            "usuario" => $usuNome,
                            "nivel" => $usuNivel,
                            "email" => $usuEmail
                        ];

                        $expirationTime = time() + (86400 * 30); // Define o tempo de expiração

                        foreach ($cookies as $nome => $valor) {
                            $valorCriptografado = encryptData($valor, $encryptionKey);
                            setcookie($nome, $valorCriptografado, $expirationTime, "/");
                        }

                        $sql = $pdo->prepare("UPDATE usuarios SET usu_erro = ?, usu_login = now(), usu_logout = NULL WHERE usu_id = ?");
                        $sql->execute([0, $usuID]);

                        $sql = $pdo->prepare("INSERT INTO registro_login VALUES (NULL,now(),?,?)");
                        $sql->execute(['login', $usuID]);

                        $data = ['resultado' => 'sucesso', 'msg' => 'OK!', 'nivel' => $usuNivel];
                        header('Content-type: application/json');
                        echo json_encode($data);
                    } else {

                        if ($usuErro >= 5) {

                            $sql = $pdo->prepare("UPDATE usuarios SET usu_status = ? WHERE usu_id = ?");
                            $sql->execute([4, $usuID]);

                            $data = ['resultado' => 'bloqueado', 'msg' => 'Atenção!'];
                            header('Content-type: application/json');
                            echo json_encode($data);
                        } else {

                            $sql = $pdo->prepare("UPDATE usuarios SET usu_erro = usu_erro+? WHERE usu_id = ?");
                            $sql->execute([1, $usuID]);

                            $data = ['resultado' => 'erro', 'msg' => 'Usuário ou Senha invalido!'];
                            header('Content-type: application/json');
                            echo json_encode($data);
                        }
                    }
                }
            } else {

                $data = ['resultado' => 'erro', 'msg' => 'Usuário ou Senha invalido!'];
                header('Content-type: application/json');
                echo json_encode($data);
            }
        }
    } // ok

    public function Perfil()
    {
        global $tabela;
        loadView('usuario', $tabela);
    } // ok

    public function Listar($busca)
    {
        global $tabela;
        loadView('listaUsuarios', $tabela, [
            'busca' => $busca[0]
        ]);
    } // ok

    public function Usuarios()
    {
        global $tabela;
        loadView('listaUsuarios', $tabela, [
            'busca' => ""
        ]);
    } // ok

    public function Permissao()
    {
        global $tabela;
        loadView('permissao', $tabela);
    }

    public function CadastrarUsuario()
    {
        global $tabela;
        loadView('cadastrarUsuario', $tabela);
    }

    // -------------------------------------------------------------//

    public function Visualizar()
    {
        $dados = selecionarDoBanco('usuarios', '*', 'usu_id = :id', [':id' => $_POST['id']]);

        header('Content-type: application/json');
        echo json_encode($dados[0]);
    } //ok

    function Verificar()
    {
        $count = selecionarDoBanco('usuarios', '*', 'usu_email = :email', [':email' => $_POST['email']]);
        $count = count($count);

        if ($count == 0) {
            $data = ['acao' => 'ok'];
        } else {
            $data = ['acao' => 'erro'];
        }

        header('Content-type: application/json');
        echo json_encode($data);
    } // ok

    public function ResetarSenha()
    {
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $cpf = $_POST['cpf'];
        $dados = selecionarDoBanco('usuarios', 'usu_email', 'usu_cpf_cnpj = :cpf', [':cpf' => $cpf]);

        if (count($dados) != 0) 
        {
            $senha = bin2hex(random_bytes(6));
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT, $options = ['cost' => 12]);

            atualizarNoBanco('usuarios', ['usu_senha' => $senhaHash, 'usu_erro' => 0], "usu_cpf_cnpj = '" . $cpf . "'", [], false);
            ResetarSenhaEmail($dados[0]['usu_email'], $senha);

            $data = ['acao' => 'ok'];
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data = ['acao' => 'erro'];
            header('Content-type: application/json');
            echo json_encode($data);
        }

    } // ok

    public function DeletarUsuario()
    {
        deletarDoBanco('usuarios', 'usu_id = ' . $_POST['Id']);
    } // ok

    public function InserirUsuario()
    {
        $dados = $_POST['dados'];
        $dados['usu_senha'] = password_hash($dados['usu_senha'], PASSWORD_DEFAULT, $options = ['cost' => 12]);
        inserirNoBanco('usuarios', $dados);
    } // ok

    function UpdateAdm()
    {
        atualizarNoBanco('usuarios', $_POST['dados'], 'usu_id = ' . $_POST['id']);
    } //ok

    function AtualizarUsuario()
    {
        $Id             = (isset($_POST['id']) ? $_POST['id'] : "");
        $senha          = (isset($_POST['senha']) ? $_POST['senha'] : "");

        $dados = [
            'usu_nome' => isset($_POST['nome']) ? $_POST['nome'] : "",
            'usu_celular' => isset($_POST['celular']) ? $_POST['celular'] : "",
            'usu_sexo' => isset($_POST['sexo']) ? $_POST['sexo'] : "",
            'usu_update' => date('Y-m-d H:i:s'),
        ];

        if ($senha != "") {
            $dados['usu_senha'] = password_hash($senha, PASSWORD_DEFAULT, $options = ['cost' => 12]); 
        } 

        atualizarNoBanco('usuarios', $dados, 'usu_id = ' . $Id, false);

        $data = ['acao' => 'ok'];
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function AdicionarToken()
    {

        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $Id     = (isset($_POST['id']) ? $_POST['id'] : "");
        $token       = (isset($_POST['token']) ? $_POST['token'] : "");

        try {

            $pdo->beginTransaction();
            $stmt = $pdo->prepare("SELECT usu_id FROM usuarios WHERE usu_token = ?");
            $stmt->execute([$token]);
            $count = $stmt->rowCount();

            if ($count > 0) {
                $sql = $pdo->prepare("UPDATE usuarios SET usu_token = ? WHERE usu_token = ?");
                $sql->execute([NULL, $token]);

                $sql = $pdo->prepare("UPDATE usuarios SET usu_token = ? WHERE usu_id = ?");
                $sql->execute([$token, $Id]);
            } else {
                $sql = $pdo->prepare("UPDATE usuarios SET usu_token = ? WHERE usu_id = ?");
                $sql->execute([$token, $Id]);
            }
            $pdo->commit();

            $data = ['acao' => 'ok'];
            header('Content-type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    }

    function imagemPerfil()
    {
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $Id         = (isset($_POST['id']) ? $_POST['id'] : "");
        $imagem64    = (isset($_POST['dadosImagem']) ? $_POST['dadosImagem'] : "");

        try {
            if ($imagem64 != "") {
                $where = "usu_id = " . $Id;
                $bdNomeImagem = 'usu_imagem_nome';  //coluna do banco com nome da imagem
                $bdlUrlImagem = 'usu_imagem_url';   //coluna do banco com url da imagem
                uploadImagem('usuarios', $imagem64, $where, $bdNomeImagem, $bdlUrlImagem, false);

                $data = ['acao' => 'ok'];
                header('Content-type: application/json');
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    } // ok

    public function Logout($idUser)
    {
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        deletarDoBanco('user_sessions', 'user_id = ' . $idUser[0]);
        atualizarNoBanco('usuarios', ['usu_logout' => 'now()'], 'usu_id = ' . $idUser[0]);

        inserirNoBanco(
            "registro_login", 
            [
                'rl_data' => 'now()',
                'rl_tipo' => 'logout',
                'rl_usuario_id' => $idUser[0],
            ]
        );

        setcookie("id", "null", 0, "/");
        setcookie("usuario", "null", 0, "/");
        setcookie("nivel", "null",  0, "/");
        setcookie("cpf", "null",  0, "/");

        if (!isset($_SESSION)) {
            session_start();
        }

        session_unset();
        session_destroy();
        header("location: /");
    } // ok
}
