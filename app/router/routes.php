<?php

$routes = [

    '/' =>             'HomeController@index',
    '/dashboard' =>    'HomeController@index',

    // Gestão de produção
    '/lista-producao' =>           'ProducaoController@Listar',
    '/cadastrar-producao' =>       'ProducaoController@Cadastrar',
    '/editar-producao' =>          'ProducaoController@Editar',
    '/atualizar-producao' =>       'ProducaoController@Atualizar',
    '/deletar-producao' =>         'ProducaoController@Deletar',

    // Gestão de projetos
    '/lista-projetos' =>           'ProjetoController@Listar',
    '/cadastrar-projeto' =>       'ProjetoController@Cadastrar',
    '/editar-projeto' =>          'ProjetoController@Editar',
    '/atualizar-projeto' =>       'ProjetoController@Atualizar',
    '/deletar-projeto' =>         'ProjetoController@Deletar',

    // Caixa
    '/fluxo-caixa' =>           'CaixaController@Listar',
    '/cadastrar-caixa' =>       'CaixaController@Cadastrar',
    '/editar-caixa' =>          'CaixaController@Editar',
    '/atualizar-caixa' =>       'CaixaController@Atualizar',
    '/deletar-caixa' =>         'CaixaController@Deletar', 

    // --------------------------------------------------------------------

    // Pedidos
    '/lista-pedidos' =>           'PedidoController@Listar',
    '/cadastrar-pedido' =>       'PedidoController@Cadastrar',
    '/editar-pedido' =>          'PedidoController@Editar',
    '/atualizar-pedido' =>       'PedidoController@Atualizar',
    '/deletar-pedido' =>         'PedidoController@Deletar',

    // Requisições de compra
    '/lista-compras' =>           'CompraController@Listar',
    '/cadastrar-compra' =>       'CompraController@Cadastrar',
    '/editar-compra' =>          'CompraController@Editar',
    '/atualizar-compra' =>       'CompraController@Atualizar',
    '/deletar-compra' =>         'CompraController@Deletar',

    // --------------------------------------------------------------------

    // Clientes
    '/lista-clientes' =>           'ClienteController@Listar',
    '/cadastrar-cliente' =>       'ClienteController@Cadastrar',
    '/editar-cliente' =>          'ClienteController@Editar',
    '/atualizar-cliente' =>       'ClienteController@Atualizar',
    '/deletar-cliente' =>         'ClienteController@Deletar',

    // Fazendas
    '/lista-fazendas' =>           'FazendaController@Listar',
    '/cadastrar-fazenda' =>       'FazendaController@Cadastrar',
    '/editar-fazenda' =>          'FazendaController@Editar',
    '/atualizar-fazenda' =>       'FazendaController@Atualizar',
    '/deletar-fazenda' =>         'FazendaController@Deletar',

    // Responsaveis e Técnicos
    '/lista-responsaveis' =>           'ResponsaveisController@Listar',
    '/cadastrar-responsaveis' =>       'ResponsaveisController@Cadastrar',
    '/editar-responsaveis' =>          'ResponsaveisController@Editar',
    '/atualizar-responsaveis' =>       'ResponsaveisController@Atualizar',
    '/deletar-responsaveis' =>         'ResponsaveisController@Deletar',

    // Produtos
    '/lista-produtos' =>           'ProdutoController@Listar',
    '/cadastrar-produto' =>       'ProdutoController@Cadastrar',
    '/editar-produto' =>          'ProdutoController@Editar',
    '/atualizar-produto' =>       'ProdutoController@Atualizar',
    '/deletar-produto' =>         'ProdutoController@Deletar',

    // Tipos de Cultivos
    '/lista-cultivos' =>           'CultivosController@Listar',
    '/cadastrar-cultivo' =>       'CultivosController@Cadastrar',
    '/editar-cultivo' =>          'CultivosController@Editar',
    '/atualizar-cultivo' =>       'CultivosController@Atualizar',
    '/deletar-cultivo' =>         'CultivosController@Deletar',

    // --------------------------------------------------------------------

    // Relatórios 
    '/relatorio-geraldeproducao' =>         'RelatorioController@GeralDeProducao',
    '/relatorio-financeiroporfazenda' =>    'RelatorioController@FinanceiroPorFazenda',
    '/relatorio-compras' =>                 'RelatorioController@Compras',
    '/relatorio-pedidosporcliente' =>       'RelatorioController@PedidosPorCliente',
    '/relatorio-entregaseprojetos' =>       'RelatorioController@EntregasEProjetos',

    '/imprimir-geraldeproducao' =>          'RelatorioController@ImpressaoGeralDeProducao',
    '/imprimir-financeiroporfazenda' =>     'RelatorioController@ImpressaoFinanceiroPorFazenda',
    '/imprimir-compras' =>                  'RelatorioController@ImpressaoCompras',
    '/imprimir-pedidosporcliente' =>        'RelatorioController@ImpressaoPedidosPorCliente',
    '/imprimir-entregaseprojetos' =>        'RelatorioController@ImpressaoEntregasEProjetos',

    // --------------------------------------------------------------------
 
    // Tipo usuario
    '/lista-tipousuario' =>         'TipoUsuarioController@Listar',
    '/cadastrar-tipousuario' =>     'TipoUsuarioController@Cadastrar',
    '/editar-tipousuario' =>        'TipoUsuarioController@Editar',
    '/atualizar-tipousuario' =>     'TipoUsuarioController@Atualizar',
    '/deletar-tipousuario' =>       'TipoUsuarioController@Deletar',
    '/permissao-tipousuario' =>     'TipoUsuarioController@permissao',
    '/obter-permissoes' =>          'TipoUsuarioController@obterPermissoes',
    '/editar-permissao' =>          'TipoUsuarioController@editarPermissao',

    // Configuração
    '/configuracao' =>              'ConfiguracaoController@index',
    '/atualizar-configuracao' =>    'ConfiguracaoController@Atualizar',
    '/atualizarimg-configuracao' => 'ConfiguracaoController@AtualizarImagem',

    // Usuario
    '/login' =>                     'UsuarioController@Login',
    '/logout/{id}' =>               'UsuarioController@Logout',
    '/login-page' =>                'UsuarioController@LoginPage',
    '/usuario' =>                   'UsuarioController@Perfil',
    '/lista-usuarios/{id}' =>       'UsuarioController@Listar',
    '/usuarios' =>                  'UsuarioController@Usuarios',
    '/permissao' =>                 'UsuarioController@Permissao',
    '/visualizar' =>                'UsuarioController@Visualizar',
    '/registro' =>                  'UsuarioController@Registro',
    '/tela-resetarsenha' =>         'UsuarioController@TelaResetarSenha',
    '/resetar-senha' =>             'UsuarioController@ResetarSenha',
    '/cadastrar-usuario' =>         'UsuarioController@CadastrarUsuario',
    '/deletar-usuario' =>           'UsuarioController@DeletarUsuario',
    '/inserir-usuario' =>           'UsuarioController@InserirUsuario',
    '/update-adm' =>                'UsuarioController@UpdateAdm',
    '/verificar' =>                 'UsuarioController@Verificar',
    '/atualizar-usuario' =>         'UsuarioController@AtualizarUsuario',
    '/adicionar-token' =>           'UsuarioController@AdicionarToken',
    '/imagem-perfil' =>             'UsuarioController@imagemPerfil',

];
