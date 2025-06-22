<?php

global $tabela;     $tabela = 'produtor';
global $sigla;      $sigla = 'prod';

class ProdutoresController extends Actions 
{
    public function Listar()
    {
        loadView('listaProdutores', "produtores",[]);
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
        header('Content-type: application/json');
        echo json_encode($dados);
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

    public function ListarProdutores()
    {
        $id = (isset($_POST['grupo_id']) ? $_POST['grupo_id'] : "");
        $dados = selecionarDoBanco(
            'usuarios',
            '*',
            'prod_grupo_id = :id',
            [':id' => $id],
            ['inner join produtor on prod_usu_id = usu_id']
        );
        header('Content-type: application/json');
        echo json_encode($dados);
    }
}

