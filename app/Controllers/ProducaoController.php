<?php

global $tabela;     $tabela = 'producao';
global $sigla;      $sigla = 'producao';

class ProducaoController extends Actions 
{
    public function Listar()
    {
        loadView('listaProducao', "producao",[]);
    } //ok

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
            echo json_encode($dados[0]);
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
    
    public function ProducaoGrupo()
    {
        $grupo_id  = (isset($_POST['grupo_id']) ? $_POST['grupo_id'] : 0);
        $dados = selecionarDoBanco(
            'producao', 
            '*', 
            'producao_grupo_id = ' . $grupo_id,
            [],
            [
                'left join usuarios on usu_id = producao_produtor_id',
                'left join produtor on prod_grupo_id = producao_grupo_id',
                'left join grupos on gru_id = producao_grupo_id',
            ]
        );    

        header('Content-type: application/json');
        echo json_encode($dados);
    }
}

