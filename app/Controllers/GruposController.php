<?php

global $tabela;
$tabela = 'grupos';
global $sigla;
$sigla = 'gru';

class GruposController extends Actions
{
    public function Listar()
    {
        loadView('listaGrupos', "grupos", []);
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
        $dados = selecionarDoBanco($tabela, '*', $sigla . '_id = :id', [':id' => $id]);
        header('Content-type: application/json');
        echo json_encode($dados[0]);
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

    public function RemoverProdutor()
    {
        $produtorId = $_POST['produtor_id'];
        $grupoId = $_POST['grupo_id'];
        deletarDoBanco('produtor', 'prod_usu_id = ' . $produtorId . ' AND prod_grupo_id = ' . $grupoId);
    }
}
