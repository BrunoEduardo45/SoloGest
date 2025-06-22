<?php

$routes = [

    '/' =>             'HomeController@index',
    '/dashboard' =>    'HomeController@index',

    // Grupos
    '/lista-grupos' =>          'GruposController@Listar',
    '/cadastrar-grupo' =>       'GruposController@Cadastrar',
    '/editar-grupo' =>          'GruposController@Editar',
    '/atualizar-grupo' =>       'GruposController@Atualizar',
    '/deletar-grupo' =>         'GruposController@Deletar',
    '/removerprodutor-grupo' => 'GruposController@RemoverProdutor',

    // Produtores
    '/lista-produtores' =>       'ProdutoresController@Listar',
    '/cadastrar-produtor' =>     'ProdutoresController@Cadastrar',
    '/editar-produtor' =>        'ProdutoresController@Editar',
    '/atualizar-produtor' =>     'ProdutoresController@Atualizar',
    '/deletar-produtor' =>       'ProdutoresController@Deletar',
    '/listar-produtores' =>      'ProdutoresController@ListarProdutores',

    // Produção
    '/lista-producao' =>         'ProducaoController@Listar',
    '/cadastrar-producao' =>     'ProducaoController@Cadastrar',
    '/editar-producao' =>        'ProducaoController@Editar',
    '/atualizar-producao' =>     'ProducaoController@Atualizar',
    '/deletar-producao' =>       'ProducaoController@Deletar',
    '/listar-producaodogrupo' => 'ProducaoController@ProducaoGrupo',

    // Relatórios 
    '/relatorio-porgrupo' =>        'RelatorioController@PorGrupo',
    '/relatorio-porprodutor' =>     'RelatorioController@PorProdutor',

    '/imprimir-porgrupo' =>         'RelatorioController@ImpressaoPorGrupo',
    '/imprimir-porprodutor' =>      'RelatorioController@ImpressaoPorProdutor',
 
    // Tipo usuario
    '/lista-tipousuario' =>         'TipoUsuarioController@Listar',
    '/cadastrar-tipousuario' =>     'TipoUsuarioController@Cadastrar',
    '/editar-tipousuario' =>        'TipoUsuarioController@Editar',
    '/atualizar-tipousuario' =>     'TipoUsuarioController@Atualizar',
    '/deletar-tipousuario' =>       'TipoUsuarioController@Deletar',
    '/permissao-tipousuario' =>     'TipoUsuarioController@permissao',
    '/obter-permissoes' =>           'TipoUsuarioController@obterPermissoes',
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
