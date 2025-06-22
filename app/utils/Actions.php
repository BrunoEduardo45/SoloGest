<?php 

Class Actions {

    public function __construct()
    {
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/RenderView.php";
        include $baseDir . "/../utils/Functions.php";
        include $baseDir . "/../utils/Pix.php";
    }

    // Ações

    public function Acao() 
    {
        global $tabela;
        global $sigla;

        $acao = $_POST['acao'];
        
        if($acao == 'selecionar') {
            $where = $_POST['where'];
            $colunas = $_POST['colunas'] ?? '*';
            $join = $_POST['join'] ?? [];
        } else {
            $id = $_POST['id'];
            $dados = $_POST['dados'];
        }

        switch ($acao) {
            case "atualizar":
                $where = $sigla . "_id = " . $id; 
                atualizarNoBanco($tabela, $dados, $where);
                break;
            case "inserir":
                inserirNoBanco($tabela, $dados);
                break;
            case "deletar":
                $where = $sigla . "_id = " . $id;
                deletarDoBanco($tabela, $where);
                break;
            case "selecionar":
                $result = selecionarDoBanco($tabela, $colunas, $where, [], $join);
                header('Content-type: application/json');
                echo json_encode($result);
                break;
        }
    }
}