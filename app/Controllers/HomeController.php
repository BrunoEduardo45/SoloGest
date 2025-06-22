<?php

global $tabela;     $tabela = 'home';
global $pagina;     $pagina = 'dashboard';

class HomeController extends Actions {
    
    public function Index()
    {
        global $tabela;
        global $pagina;
        loadView($pagina ?? $tabela, $tabela,[]);
    }

    public function Adm()
    {
        global $tabela;
        loadView('adm', $tabela,[]);
    }

    public function Click()
    {
        $usuId = $_POST['id'];
        inserirNoBanco('live', ['live_usu_id' => $usuId, 'live_data' => date('Y-m-d')]);
    }
}