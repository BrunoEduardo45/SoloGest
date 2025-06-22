<?php

global $tabela;     $tabela = 'despesas_administrativas';
global $sigla;      $sigla  = 'da';

$baseDir = dirname(__FILE__);
include $baseDir . "/../utils/Database.php";

global $pagina;
switch ($pais) {
    case 1:
        $pagina = 'Despesas Administrativas'; // pt
        break;
    case 2:
        $pagina = 'Administrative Expenses'; // en
        break;
    case 3:
        $pagina = 'Gastos Administrativos'; // es
        break;
    case 4:
        $pagina = 'Spese Amministrative'; // it
        break;
    case 5:
        $pagina = 'Dépenses Administratives'; // fr
        break;
    default:
        $pagina = 'Administrative Expenses'; // en as default
}

Class DespesasAdmController extends Actions {
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

    // Rotas 

    public function Index()
    {
        global $tabela;
        global $pagina;
        global $usuNome;
        global $usuFuncao;
        global $sigla; 
        
        $tipo = "index";
        $titulo = $pagina;

        loadView($tabela, $tabela,[
            'titulo' => $titulo,
            'pagina' => $pagina,
            'usuNome' => $usuNome,
            'usuFuncao' => $usuFuncao,
            'tipo' => $tipo,
            'sigla' => $sigla
        ]);
    }

    public function Listar()
    {
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        global $tabela;
        global $pagina;
        global $usuNome;
        global $usuFuncao;
        global $sigla;

        $fimTitulo = "";

        $tipo = "listar";

        if (substr($pagina, -1) == "s") {
            $fimTitulo = "";
        } else {

            if($sigla == 'for') 
            {
                $fimTitulo = "es";
            } 
            else if ($pagina != 'Estoque' && $pagina != 'Contas a pagar')
            { 
                $fimTitulo = "s"; 
            }             
        }

        switch ($pais) {
            case 1: // Português
                $titulo = "Lista de " . strtolower($pagina) . $fimTitulo;
                break;
            case 2: // Inglês
                $titulo = $pagina . $fimTitulo . " list";
                break;
            case 3: // Espanhol
                $titulo = "Lista de " . strtolower($pagina) . $fimTitulo;
                break;
            case 4: // Italiano
                $titulo = "Lista di " . strtolower($pagina) . $fimTitulo;
                break;
            case 5: // Francês
                $titulo = "Liste des " . strtolower($pagina) . $fimTitulo;
                break;
            default:
                $titulo = $pagina . $fimTitulo . " list";
                break;
        }

        $lista = selecionarDoBanco($tabela);
        loadView($tabela, $tabela, [
            'titulo' => $titulo,
            'pagina' => $pagina,
            'usuNome' => $usuNome,
            'usuFuncao' => $usuFuncao,
            'lista' => $lista,
            'tipo' => $tipo,
            'sigla' => $sigla
        ]);
    }

    public function Detalhes($id)
    {
        global $tabela;
        global $controller;
        global $usuNome;
        global $usuFuncao;
        global $sigla;
        global $titulo;

        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $tipo = "detalhes";

        switch ($pais) {
            case 1: // Português
                $titulo = $titulo != "" ? $titulo : "Detalhe de " . mb_strtolower($controller, 'UTF-8');
                break;
            case 2: // Inglês
                $titulo = $titulo != "" ? $titulo : "Detail " . mb_strtolower($controller, 'UTF-8');
                break;
            case 3: // Espanhol
                $titulo = $titulo != "" ? $titulo : "Detalle de " . mb_strtolower($controller, 'UTF-8');
                break;
            case 4: // Italiano
                $titulo = $titulo != "" ? $titulo : "Dettaglio di " . mb_strtolower($controller, 'UTF-8');
                break;
            case 5: // Francês
                $titulo = $titulo != "" ? $titulo : "Détail de " . mb_strtolower($controller, 'UTF-8');
                break;
            default:
                $titulo = $titulo != "" ? $titulo : "Detail " . mb_strtolower($controller, 'UTF-8');
                break;
        }

        $dados = selecionarDoBanco($tabela, '*', $sigla . '_id = :id', [':id' => $id[0]]);

        loadView('detalhes', $tabela, [
            'titulo' => $titulo,
            'pagina' => $controller,
            'usuNome' => $usuNome,
            'usuFuncao' => $usuFuncao,
            'dados' => $dados[0],
            'tipo' => $tipo,
            'sigla' => $sigla
        ]);
    }

    public function Atualizar($id)
    {
        global $tabela;
        global $pagina;
        global $usuNome;
        global $usuFuncao;
        global $sigla;
        
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $tipo = "atualizar";

        switch ($pais) {
            case 1: // Português
                $titulo = "Atualizar " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 2: // Inglês
                $titulo = "Update " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 3: // Espanhol
                $titulo = "Actualizar " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 4: // Italiano
                $titulo = "Aggiornare " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 5: // Francês
                $titulo = "Mettre à jour " . mb_strtolower($pagina, 'UTF-8');
                break;
            default:
                $titulo = "Update " . mb_strtolower($pagina, 'UTF-8');
                break;
        }

        $dados = selecionarDoBanco($tabela, '*', $sigla . '_id = :id', [':id' => $id[0]]);
        loadView('atualizar', $tabela, [
            'titulo' => $titulo,
            'pagina' => $pagina,
            'usuNome' => $usuNome,
            'usuFuncao' => $usuFuncao,
            'dados' => $dados[0],
            'tipo' => $tipo,
            'sigla' => $sigla
        ]);
    }

    public function Inserir()
    {
        global $tabela;
        global $pagina;
        global $usuNome;
        global $usuFuncao;
        global $sigla;
        
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        $tipo = "inserir";

        switch ($pais) {
            case 1: // Português
                $titulo = "Registrar " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 2: // Inglês
                $titulo = "Register " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 3: // Espanhol
                $titulo = "Registrar " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 4: // Italiano
                $titulo = "Registrare " . mb_strtolower($pagina, 'UTF-8');
                break;
            case 5: // Francês
                $titulo = "Enregistrer " . mb_strtolower($pagina, 'UTF-8');
                break;
            default:
                $titulo = "Register " . mb_strtolower($pagina, 'UTF-8');
                break;
        }

        loadView('cadastrar', $tabela, [
            'titulo' => $titulo,
            'pagina' => $pagina,
            'usuNome' => $usuNome,
            'usuFuncao' => $usuFuncao,
            'tipo' => $tipo,
            'sigla' => $sigla
        ]);
    }

    public function BaixaDespesaAdm()
    {
        $despesa = $_POST['despesa']; 
        $data_baixa = $_POST['data_baixa'];
        $data_pagamento = $_POST['data_pagamento'];
        $valor_pagamento = $_POST['valor_pagamento']; 
        $forma_pagamento = $_POST['forma_pagamento']; 
        $situacao = $_POST['situacao']; 
        $usuario = $_POST['usuario']; 

        $dados = [
            "bd_despesas_id" => $despesa,
            "bd_data_baixa" => $data_baixa,
            "bd_data_pagamento" => $data_pagamento,
            "bd_valor_pagamento" => $valor_pagamento,
            "bd_forma_pagamento" => $forma_pagamento,
            "bd_situacao" => $situacao,
            "bd_id_usuario" => $usuario,
        ];

        inserirNoBanco('baixa_despesas_adm', $dados);
    }

    public function RemoverBaixaDespesaAdm()
    {
        deletarDoBanco('baixa_despesas_adm', 'bd_id = '.$_POST['id']);
    }

 }