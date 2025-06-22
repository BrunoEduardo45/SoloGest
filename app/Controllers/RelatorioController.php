<?php

global $tabela;     $tabela = 'relatorio';
global $sigla;      $sigla = 'rel';

class RelatorioController extends Actions 
{
    public function PorGrupo()
    {
        global $tabela;
        loadView('relatorioPorGrupo', $tabela,[]);
    }

    public function PorProdutor()
    {
        global $tabela;
        loadView('relatorioPorProdutor', $tabela,[]);
    }
    
    // ---------------- IMPRESSÃO --------------------

    public function ImpressaoPorGrupo() { 
        global $tabela;
        loadView('imprimirRelatorioPorGrupo', $tabela,[], false, false);
    }

    public function ImpressaoPorProdutor() { //ok
        global $tabela;
        loadView('imprimirRelatorioPorGrupo', $tabela,[], false, false);
    }

}