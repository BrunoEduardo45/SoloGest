<?php

global $tabela;     $tabela = 'tipo_usuario';
global $sigla;      $sigla = 'tp';

class TipoUsuarioController extends Actions 
{
    public function Listar()
    {
        loadView('listaTipoUsuario', "tipoUsuario",[]);
    }

    public function Cadastrar()
    {
        global $tabela;
        $dados = $_POST['dados'];
        inserirNoBanco($tabela, $dados);
    }

    public function Editar()
    {
        global $tabela;
        global $sigla;
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = selecionarDoBanco($tabela, '*', $sigla.'_id = :id', [':id' => $id]);
        if ($dados !== null) {
            $data = [
                'id'            => $dados[0]['tp_id'],
                'nome'          => $dados[0]['tp_nome'],
                'status'        => $dados[0]['tp_status'],
                'acao'          => 'editar'
            ];
            header('Content-type: application/json');
            echo json_encode($data);
        }
    }
    
    public function Atualizar()
    {
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = $_POST['dados'];

        $where = $sigla . "_id = " . $id;
        atualizarNoBanco($tabela, $dados, $where);
    }

    public function Deletar()
    {
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");

        $where = $sigla . "_id = " . $id;
        deletarDoBanco($tabela, $where);
    }

    public function editarPermissao()
    {
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $TipoUsuarioId  = (isset($_POST['usuario']) ? $_POST['usuario'] : 0);
        $permissao      = (isset($_POST['permissao']) ? $_POST['permissao'] : 0);
    
        $stmt = $pdo->prepare("DELETE FROM permissao WHERE per_nivel = ?");
        $stmt->execute([$TipoUsuarioId]);
    
        foreach ($_POST['permissao'] as $tela_id => $permissao) 
        {
            $stmt = $pdo->prepare("INSERT INTO permissao VALUES (null,?,?,?)");
            $stmt->execute([$TipoUsuarioId,$tela_id,$permissao]);
            //$conn->query("INSERT INTO permissoes (usuario_id, tela_id, permissao) VALUES ($usuario_id, $tela_id, $permissao)");
        }
    
    }
    
    public function obterPermissoes()
    {
    
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $TipoUsuarioId  = (isset($_POST['usuario']) ? $_POST['usuario'] : 0);

        $stmt = $pdo->prepare("SELECT * FROM permissao WHERE per_nivel = ?");
        $stmt->execute([$TipoUsuarioId]);
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach($list as $values){
            $permissoes[$values['per_tela_id']] = $values['per_visualizar'];
        }
    
        echo json_encode($permissoes);
    }
}

