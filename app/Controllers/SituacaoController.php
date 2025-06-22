<?php

global $tabela;     $tabela = 'situacao';
global $sigla;      $sigla = 'sit';

class SituacaoController extends Actions 
{
    public function Listar()
    {
        global $tabela;
        loadView('listaSituacao', $tabela,[]);
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
                'id'     => $dados[0]['sit_id'],
                'nome'   => $dados[0]['sit_nome'],
                'status' => $dados[0]['sit_status'],
                'acao'   => 'editar'
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
}
