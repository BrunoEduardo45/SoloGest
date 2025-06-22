<?php

function inserirNoBanco($tabela, $dados, $retorno = true)
{
    include "Database.php";

    $parametrosString = implode(", ", array_keys($dados));
    $parametrosValueString = implode("', '", $dados);
    
    try {
        $pdo->beginTransaction();
        $pdo->prepare("INSERT INTO $tabela ($parametrosString) VALUES ('$parametrosValueString')")->execute();
        $id = $pdo->lastInsertId();
        $pdo->commit();

        if($retorno == true) {
            $data = ['success' => 'Inserido com sucesso!'];
            header('Content-type: application/json');
            echo json_encode($data);
        }
        return $id;
    } catch (Exception $e) {
        $pdo->rollBack();
        if($retorno == true) {
            $data = ['success' => '', 'error' => 'Ocorreu um erro! Nossa equipe de suporte já foi informada. Aguarde!', 'erro' => $e];
            header('Content-type: application/json');
            echo json_encode($data);
        } 
        return $id;
    }
}

function atualizarNoBanco($tabela, $dados, $where = null, $retorno = true)
{
    include "Database.php";

    $setString = '';
    foreach ($dados as $campo => $valor) {
        $setString .= "$campo = '$valor', ";
    }
    $setString = rtrim($setString, ', ');

    try {
        $pdo->beginTransaction();
        $sql = "UPDATE $tabela SET $setString";
        if ($where) {
            $sql .= " WHERE $where";
        }
        $pdo->prepare($sql)->execute();
        $pdo->commit();

        if($retorno == true) {
            $data = ['success' => 'Atualizado com sucesso!'];
            header('Content-type: application/json');
            echo json_encode($data);
        } else {}
    } catch (Exception $e) {
        $pdo->rollBack();

        if($retorno == true) {
            $data = ['success' => '', 'error' => 'Ocorreu um erro! Nossa equipe de suporte já foi informada. Aguarde!', 'erro' => $e];
            header('Content-type: application/json');
            echo json_encode($data);
        } else {}
    }
}

function deletarDoBanco($tabela, $where, $retorno = true)
{
    include "Database.php";

    try {
        $pdo->beginTransaction();
        $pdo->query("DELETE FROM $tabela WHERE $where")->execute();
        $pdo->commit();

        if($retorno == true) {
            $data = ['success' => 'Deletado com sucesso!'];
            header('Content-type: application/json');
            echo json_encode($data);
        } else {}
        
    } catch (Exception $e) {
        $pdo->rollBack();

        if($retorno == true) {
        $data = ['success' => '', 'error' => 'Ocorreu um erro! Nossa equipe de suporte já foi informada. Aguarde!', 'erro' => $e];
        header('Content-type: application/json');
        echo json_encode($data);
        } else {}
    }
}

function selecionarDoBanco($tabela, $colunas = '*', $where = '', $parametros = [], $joins = [])
{
    include "Database.php";

    try {
        $sql = "SELECT $colunas FROM $tabela";

        if (!empty($joins)) {
            $sql .= " " . implode(" ", $joins);
        }

        if ($where) {
            $sql .= " WHERE $where";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($parametros);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return $result;
        } else {
            return $result = [];
        }
    } catch (PDOException $e) {}
}

function chamarProcedure($nomeProcedure, $parametros)
{
    include "Database.php";

    try {
        $stmt = $pdo->prepare("CALL $nomeProcedure($parametros)");
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        return false;
    }
}

function uploadImagem($tabela, $imagem, $where, $campoImagem, $campoCaminho, $retorno = true)
{
    include 'Database.php';

    $baseDiretorio = 'app/public/imagens/';
    $folderPath = './app/public/imagens/';

    //verificar se já existe a imagem na pasta para remover
    $list = selecionarDoBanco($tabela,$campoImagem,$where);
    foreach($list as $values){
        $imagemPasta = $values[$campoImagem];
    }
    if($imagemPasta != ""){
        unlink($folderPath . $imagemPasta);
    }

    //verificar se já existe a imagem na pasta para remover
    $image_parts = explode(";base64,", $imagem);
    $image_base64 = base64_decode($image_parts[1]);
    if($image_base64 == "") {
        $image_base64 = base64_decode($image_parts[0]);
    }
    $nomeImagem = uniqid() . '.png';

    $file = $folderPath . $nomeImagem;
    file_put_contents($file, $image_base64);
    $caminhoImagem = $baseDiretorio . $nomeImagem;

    if($campoImagem != "")
    {
        $dados[$campoImagem] = $nomeImagem;
    }
    $dados[$campoCaminho] = $caminhoImagem;

    $setString = '';
    foreach ($dados as $campo => $valor) {
        $setString .= "$campo = :$campo, ";
    }
    $setString = rtrim($setString, ', ');
    $sql = "UPDATE $tabela SET $setString";
    if ($where) {
        $sql .= " WHERE $where";
    }

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare($sql);
        foreach ($dados as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        $stmt->execute();
        $pdo->commit();

        if ($retorno == true) {
            $data = ['success' => 'Atualizado com sucesso!'];
            header('Content-type: application/json');
            echo json_encode($data);
        } 
    } catch (Exception $e) {
        $pdo->rollBack();

        if ($retorno == true) {
            $data = ['success' => '', 'error' => 'Ocorrreu um erro! Nossa equipe de suporte já foi informada. Por favor Aguarde!', 'erro' => $e];
            header('Content-type: application/json');
            echo json_encode($data);
        }
    }
}

function uploadArquivo($tabela, $arquivos, $Id, $campoArquivo, $campoCaminho, $bdCampoId, $retorno = true)
{
    include 'Database.php';

    $baseDiretorio = 'app/public/arquivos/' . $tabela . '_' . $Id . '/';
    $folderPath = './app/public/arquivos/' . $tabela . '_' . $Id . '/';

    // Criar uma pasta para cada $Id, se não existir
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true); // 0777 é permissão para leitura, gravação e execução
    }

    $caminhosArquivos = [];

    foreach ($arquivos['tmp_name'] as $indice => $tmp_name) {
        $nomeArquivo = $arquivos['name'][$indice];
        $caminhoDestino = $folderPath . $nomeArquivo;

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($tmp_name, $caminhoDestino)) {
            $caminhosArquivos[] = $baseDiretorio . $nomeArquivo;
        } else {
            echo "Erro ao mover o arquivo $nomeArquivo.";
        }
    }    

    // Preparar os dados para inserção na base de dados
    $dados = [];
    foreach ($caminhosArquivos as $caminhoArquivo) {
        $dados[] = [
            $campoArquivo => basename($caminhoArquivo), // Nome do arquivo
            $campoCaminho => $caminhoArquivo,           // Caminho completo do arquivo
            $bdCampoId    => $Id                        // ID associado ao arquivo
        ];
    }

    // Preparar a consulta SQL para inserir os arquivos na base de dados
    $sql = "INSERT INTO $tabela ($campoArquivo, $campoCaminho, $bdCampoId) VALUES ";
    $sqlParams = [];
    foreach ($dados as $indice => $valores) {
        $sqlParams[] = "(:arquivo$indice, :caminho$indice, :id$indice)";
    }
    $sql .= implode(", ", $sqlParams);

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare($sql);
        foreach ($dados as $indice => $valores) {
            $stmt->bindValue(":arquivo$indice", $valores[$campoArquivo]);
            $stmt->bindValue(":caminho$indice", $valores[$campoCaminho]);
            $stmt->bindValue(":id$indice", $valores[$bdCampoId]);
        }
        $stmt->execute();
        $pdo->commit();

        if ($retorno == true) {
            $data = ['success' => 'Arquivos inseridos com sucesso!'];
            header('Content-type: application/json');
            echo json_encode($data);
        }
    } catch (Exception $e) {
        $pdo->rollBack();

        if ($retorno == true) {
            $data = ['success' => '', 'error' => 'Ocorrreu um erro! Nossa equipe de suporte já foi informada. Por favor, aguarde!', 'erro' => $e];
            header('Content-type: application/json');
            echo json_encode($data);
        }
    }
}

function encryptData($data, $key)
{
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivSize);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($data, $key)
{
    $data = base64_decode($data);
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivSize);
    $encrypted = substr($data, $ivSize);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

function enviarPush($idUsuario, $tituloPush, $mensagemPush, $urlPush)
{
    include 'Database.php';

    $stmt = $pdo->prepare("SELECT usu_token FROM usuarios WHERE usu_id = ? LIMIT 1");
    $stmt->execute([$idUsuario]);
    $count = $stmt->rowCount();

    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dados as $values) {
        $token = $values['usu_token'];
    }

    if ($count > 0) {

        $url = "https://fcm.googleapis.com/fcm/send";

        $server_key = "AAAAt1HwTjc:APA91bHqb2FyDnBbYhRrZcGj0YW8pqxdVIYNLkFlYPXhX3eEupBKlEN3P0z6sm30uWe72CxrM7paQXrelAxyXa4CPbvobz_S6C3KQs057-t9EF95weQy5yKToYYuammI-QYCcXk20fVC";

        $message = array(
            "data" => array(
                "title" => "$tituloPush",
                "body" => "$mensagemPush",
                "icon" => "https://cdn-icons-png.flaticon.com/512/1041/1041916.png",
                "image" => "https://images.unsplash.com/photo-1543702404-38c2035462ad?auto=format&fit=crop&q=80&w=1740&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                "click_action" => "$urlPush"
            ),
            "registration_ids" => [
                "$token"
            ]
        );

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true, // Adicione esta linha
            //CURLOPT_VERBOSE => false, // Adicione esta linha para desativar logs
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=" . $server_key,
                "Content-Type: application/json",
            ),
            CURLOPT_POSTFIELDS => json_encode($message),
        );

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if ($response === false) {
            $data = ['success' => '', 'error' => 'Ocorrreu um erro! Nossa equipe de suporte já foi informada. Por favor, aguarde!', 'erro' => $e];
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data = ['success' => 'Arquivos inseridos com sucesso!'];
            header('Content-type: application/json');
            echo json_encode($data);
        }

        curl_close($curl);
    }
}

function ResetarSenhaEmail($email, $senha)
{
    include 'Database.php';

    $nomeMail = $nomeSistema;
    $assunto = "🔒 Reset de Senha";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=uft-8' . "\r\n";
    $headers .= 'From: ' . $nomeMail . ' <' . $emailPadrao . '>';

    $mensagem = '<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1; font-family: sans-serif; font-weight: 400; font-size: 15px; line-height: 1.8; color: rgba(0, 0, 0, .6); min-height: 650px">
        <div style="width: 100%; background-color: #f1f1f1;">
            <div style="max-width: 600px; margin: 0 auto;">
                <div align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="padding-top: 30px;">
                <div style="padding:2em 0 2em 0;background:' . $corPrimaria . ';border-radius:20px 20px 0px 0px">
                    <img src="' . $baseUrl . $urlLogo . '" alt=" ' . $nomeSistema . ' " width="300">
                </div>
                    <div style="padding: 2em 0 2em 0; background: #ffffff;padding-top:20px">
                        <div style="padding: 0 2.5em; text-align: center; color: rgba(0, 0, 0, .6)">
                            <h2>Senha resetada com Sucesso!</h2>
                            <h4>Segue abaixo sua nova senha para acessar o painel</h4>
                            <p>Login: ' . $email . '<br>
                            Nova Senha: ' . $senha . '</p>
                            <p>
                                <a href="' . $baseUrl . '" style="padding: 10px 15px; display: inline-block;border-radius: 5px; background: ' . $corPrimaria . '; color: #ffffff; text-decoration: none;">
                                    Painel de Controle
                                </a>
                            </p>
                            <p><strong>Observação:</strong> Não esqueça de alterar sua senha no primeiro acesso.</p>
                        </div>
                    </div>
                    <div style="text-align: center; background: #f7fafa; padding: 10px; border-radius: 0px 0px 20px 20px;">
                        <p>Sistema desenvolvido por <a href="' . $siteEmpresa . '"
                                style="color: rgba(0,0,0,.8); font-weight: bold; text-decoration: none">' . $nomeEmpresa . '</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>';


    $enviaremail = mail($email, $assunto, $mensagem, $headers);
    if ($enviaremail) {
        //echo "Sucesso";
    } else {
        //echo "Erro";
    }
}