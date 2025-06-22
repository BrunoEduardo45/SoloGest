<?php

global $tabela;     $tabela = 'classificados';
global $sigla;      $sigla = 'clas';

class ClassificadosController extends Actions 
{
    // Classificados
    public function App()
    {
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        loadView('appClassificados', $tabela,[
            'pagina' => $pagina,
        ]);
    }

    public function AppProdutos($id)
    {
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        loadView('appProdutosClassificados', $tabela,[
            'pagina' => $pagina,
            'idCategoria' => $id[0],
        ]);
    }

    public function Listar()
    {
        loadView('listaClassificados', "classificados",[]);
    }

    public function ListaAprovacao()
    {
        loadView('listaAprovacao', "classificados",[]);
    }

    public function Abrir($id)
    {
        loadView('classificado', "classificados",[
            'IDClassificado' => $id[0],
        ]);
    }

    public function BuscarCategorias()
    {
        $id = $_POST['id'];
        $data = selecionarDoBanco('classificados_categoria','*','clas_cat_status = 1 and clas_cat_tipo_id =' . $id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function BuscarClassificados()
    {
        $id = $_POST['id'];
        $data = selecionarDoBanco('classificados', '*', 'clas_status = 1 and clas_categoria_id = ' . $id);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function BuscarClassificadosIgreja()
    {
        $id = $_POST['igreja'];
        $situacao = $_POST['situacao'];

        $joins = [
            'LEFT JOIN tipo_categoria ON (tip_cat_id = clas_tipo_id)', 
            'LEFT JOIN classificados_categoria ON (clas_cat_id = clas_categoria_id)',
            'LEFT JOIN usuarios ON (usu_id = clas_usuario_id)',
            'LEFT JOIN igreja ON (ig_id = clas_igreja)'
        ];

        $where = "clas_status = 1";

        if($id) {
            $where = $where . ' and clas_igreja = ' . $id;
        }

        if($situacao > 0) {
            $where = $where . ' and clas_situacao = ' . $situacao;
        }

        $data = selecionarDoBanco('classificados', '*', $where, [], $joins);

        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function CadastrarClassificado()
    {
        global $tabela;
        loadView('cadastrarClassificado', $tabela,[]);
    }

    public function AtualizarClassificado($id)
    {
        global $tabela;
        loadView('cadastrarClassificado', $tabela,[
            'id' => $id
        ]);
    }

    public function AprovacaoClassificado($id)
    {
        global $tabela;
        loadView('aprovacao', $tabela,[
            'id' => $id
        ]);
    }

    public function Cadastrar()
    {
        global $tabela;
        global $sigla;
        $imagem64    = (isset($_POST['imagem']) ? $_POST['imagem'] : "");
        $dados       = $_POST['dados'];

        try {
            $id = inserirNoBanco($tabela, $dados, false);
            if ($imagem64 != ""){
                $where = $sigla."_id = " . $id;
                $bdNomeImagem = $sigla.'_nome_imagem';
                $bdlUrlImagem = $sigla.'_url_imagem';
                uploadImagem($tabela, $imagem64, $where, $bdNomeImagem, $bdlUrlImagem, false);
            }
            $data = ['acao' => 'salvo'];
            header('Content-type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            sendTelegramMessage($e);
        }     
    }

    public function Atualizar()
    {
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = $_POST['dados'];
        $imagem64    = (isset($_POST['imagem']) ? $_POST['imagem'] : "");
        
        $where = $sigla."_id = " . $id;
        $bdNomeImagem = $sigla.'_nome_imagem';
        $bdlUrlImagem = $sigla.'_url_imagem';

        try 
        {
            if ($imagem64 != "")
            {
                uploadImagem($tabela, $imagem64, $where, $bdNomeImagem, $bdlUrlImagem, false);
            }
            
            atualizarNoBanco($tabela, $dados, $where);

            $data = ['acao' => 'salvo'];
            header('Content-type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            sendTelegramMessage($e);
        } 
    }

    public function Deletar()
    {
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");

        $where = $sigla . "_id = " . $id;
        deletarDoBanco($tabela, $where);
    }

    public function AtualizarRevisao()
    {
        global $tabela;
        global $sigla; 
        $id = $_POST['id'];

        atualizarNoBanco($tabela, ['clas_situacao' => $_POST['situacao']], $sigla."_id = " . $id);
    }

    // Categorias do classificado
    public function ListarCategoria()
    {
        loadView('categoria', "classificados");
    }

    public function CadastrarCategoria()
    {
        $dados = $_POST['dados'];
        inserirNoBanco('classificados_categoria', $dados);
    }

    public function EditarCategoria()
    {
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = selecionarDoBanco('classificados_categoria', '*', 'clas_cat_id = :id', [':id' => $id]);
        if ($dados !== null) {
            $data = [
                'id'            => $dados[0]['clas_cat_id'],
                'titulo'        => $dados[0]['clas_cat_titulo'],
                'tipo'          => $dados[0]['clas_cat_tipo_id'],
                'status'        => $dados[0]['clas_cat_status'],
                'acao'          => 'editar'
            ];
            header('Content-type: application/json');
            echo json_encode($data);
        }
    }
    
    public function AtualizarCategoria()
    {
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = $_POST['dados'];

        $where = "clas_cat_id = " . $id;
        atualizarNoBanco('classificados_categoria', $dados, $where);
    }

    public function DeletarCategoria()
    {
        $id = (isset($_POST['id']) ? $_POST['id'] : "");

        $where = "clas_cat_id = " . $id;
        deletarDoBanco('classificados_categoria', $where);
    }

}

