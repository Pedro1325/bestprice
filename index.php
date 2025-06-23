<?php

require __DIR__ . '/app/controllers/HomeController.php';
require __DIR__ . '/app/controllers/CadastroController.php';
require __DIR__ . '/app/controllers/AuthController.php';
require __DIR__ . '/app/controllers/PerfilController.php';
require __DIR__ . '/app/controllers/SobreController.php';
require __DIR__ . '/app/controllers/EnderecoController.php';
require __DIR__ . '/app/controllers/Error404Controller.php';
require __DIR__ . '/app/controllers/ProdutoController.php';
require __DIR__ . '/app/controllers/EstoqueController.php';
require __DIR__ . '/app/controllers/AdminController.php';
require __DIR__ . '/app/controllers/CarrinhoController.php';
require __DIR__ . '/app/controllers/PagamentoController.php';
require __DIR__ . '/app/controllers/DashboardController.php';
require __DIR__ . '/app/controllers/CategoriaController.php';
require __DIR__ . '/app/controllers/FreteController.php';


require __DIR__ . '/router.php';

$router = new Router();

$router->add('home',                    'HomeController',           'index');
$router->add('produto',                 'ProdutoController',        'index');
$router->add('sobre',                   'SobreController',          'index');
$router->add('cadastro',                'CadastroController',       'salvar');
$router->add('login@verifica',          'AuthController',           'verificaSessao');
$router->add('login',                   'AuthController',           'login');
$router->add('logout',                  'AuthController',           'logout');
$router->add('perfil',                  'PerfilController',         'index');
$router->add('endereco',                'EnderecoController',       'showForm');
$router->add('endereco@cep',            'EnderecoController',       'buscarCep');
$router->add('endereco@salvar',         'EnderecoController',       'salvar');
$router->add('endereco@excluir',        'EnderecoController',       'excluir');
$router->add('admin',                   'AdminController',          'checkAdminAccess');
$router->add('estoque',                 'AdminController',          'checkAdminAccess');
$router->add('adicionar@estoque',       'EstoqueController',        'adicionarEstoque');
$router->add('excluir@estoque',         'EstoqueController',        'excluirEstoque');
$router->add('editar@estoque',          'EstoqueController',        'editarEstoque');
$router->add('desvincula@estoque',      'EstoqueController',        'desvincularEstoque');
$router->add('vincular@estoque',        'EstoqueController',        'vincularEstoque');
$router->add('add-produto',             'AdminController',          'checkAdminAccess');
$router->add('gestao-produto',          'AdminController',          'checkAdminAccess');
$router->add('produto@salvar',          'ProdutoController',        'salvarProduto'); 
$router->add('produto@excluir',         'ProdutoController',        'excluirProduto'); 
$router->add('produto@editar',          'ProdutoController',        'editarProduto'); 
$router->add('404',                     'Error404Controller',       'index');
$router->add('carrinho',                'CarrinhoController',       'index');
$router->add('carrinho@adicionar',      'CarrinhoController',       'adicionar');
$router->add('carrinho@atualizar',      'CarrinhoController',       'atualizar');
$router->add('carrinho@remover',        'CarrinhoController',       'remover');
$router->add('carrinho@finalizar',      'CarrinhoController',       'finalizar');
$router->add('frete@calcular',          'FreteController',          'calcular');
$router->add('pagamento',               'PagamentoController',      'index');
$router->add('categoria',               'CategoriaController',      'index');
$router->add('adicionar@categoria',     'CategoriaController',      'adicionar');  
$router->add('editar@categoria',        'CategoriaController',      'editar');
$router->add('excluir@categoria',       'CategoriaController',      'excluir');
$router->run();

?>
