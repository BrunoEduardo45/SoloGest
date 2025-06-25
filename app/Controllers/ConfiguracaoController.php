<?php

global $tabela;     $tabela = 'sistema';
global $sigla;      $sigla = 'sis';

class ConfiguracaoController extends Actions 
{
    public function Index()
    {
        loadView('configuracao', "configuracao",[]);
    }

    public function Atualizar()
    {
        global $tabela;
        $dados = $_POST['dados'];
        atualizarNoBanco($tabela, $dados);
    }

    public function AtualizarImagem()
    {
        global $tabela;
        global $sigla;
        $imagem64 = $_POST['imagem'];

        $where = $sigla."_nome is not null";
        $bdlUrlImagem = $sigla.'_url_logo';
        $bdNomeImagem = "";

        try {

            if ($imagem64 != ""){
                uploadImagem($tabela, $imagem64, $where, $bdNomeImagem, $bdlUrlImagem, false);
            }

            $data = ['acao' => 'salvo'];
            header('Content-type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            //sendTelegramMessage($e);
        } 
    }
}