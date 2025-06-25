<?php

global $tabela;     $tabela = 'relatorio';
global $sigla;      $sigla = 'rel';

class RelatorioController extends Actions 
{
    public function GeralDeProducao()
    {
        global $tabela;
        loadView('relatorioGeralDeProducao', $tabela,[]);
    }

    public function FinanceiroPorFazenda()
    {
        global $tabela;
        loadView('relatorioFinanceiroPorFazenda', $tabela,[]);
    }

    public function Compras()
    {
        global $tabela;
        loadView('relatorioCompras', $tabela,[]);
    }

    public function PedidosPorCliente()
    {
        global $tabela;
        loadView('relatorioPedidosPorCliente', $tabela,[]);
    }

    public function EntregasEProjetos()
    {
        global $tabela;
        loadView('relatorioEntregasEProjetos', $tabela,[]);
    }
    
    // ---------------- IMPRESSÃO --------------------

    public function ImpressaoGeralDeProducao() { 
        global $tabela;
        loadView('imprimirRelatorioGeralDeProducao', $tabela,[], false, false);
    }

    public function ImpressaoFinanceiroPorFazenda() { 
        global $tabela;
        loadView('imprimirRelatorioFinanceiroPorFazenda', $tabela,[], false, false);
    }

    public function ImpressaoCompras() { 
        global $tabela;
        loadView('imprimirRelatorioCompras', $tabela,[], false, false);
    }

    public function ImpressaoPedidosPorCliente() { 
        global $tabela;
        loadView('imprimirRelatorioPedidosPorCliente', $tabela,[], false, false);
    }

    public function ImpressaoEntregasEProjetos() { 
        global $tabela;
        loadView('imprimirRelatorioEntregasEProjetos', $tabela,[], false, false);
    }

}