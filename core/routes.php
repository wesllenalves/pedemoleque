<?php

$routes[] = ['/', 'HomeController@index'];
$routes[] = ['/index', 'HomeController@index'];
$routes[] = ['/index/login', 'HomeController@login'];
$routes[] = ['/index/login/verificar', 'HomeController@verificaLogin'];
$routes[] = ['/index/cadastro', 'HomeController@indexCadastro'];
$routes[] = ['/index/cadastro/cliente', 'HomeController@cadastroCliente'];

$routes[] = ['/index/checkout', 'HomeController@checkout'];

$routes[] = ['/cliente/minhaconta', 'ClienteController@minhaconta'];
$routes[] = ['/cliente/minhaconta/editar', 'ClienteController@minhacontaeditar'];
$routes[] = ['/cliente/minhaconta/editar/enviar', 'ClienteController@minhaContaEditarEnviar'];
$routes[] = ['/cliente/minhaconta/deletar', 'ClienteController@deletar'];
$routes[] = ['/cliente/minhaconta/listaCompras', 'ClienteController@ListaCompras'];
$routes[] = ['/cliente/minhaconta/comprar', 'ClienteController@comprar'];

$routes[] = ['/admin', 'AdminController@index'];
$routes[] = ['/admin/sair', 'AdminController@logout'];
$routes[] = ['/admin/produtos', 'AdminController@produto'];
$routes[] = ['/admin/cadastro/produto', 'AdminController@viewCadastroProduto'];
$routes[] = ['/admin/cadastro/produto/enviar', 'AdminController@cadastroProduto'];
$routes[] = ['/dashboard/listar/clientes', 'AdminController@listarCliente'];
$routes[] = ['/dashboard/alterar/cliente/{id}', 'AdminController@editarCliente'];
$routes[] = ['/dashboard/update/cliente', 'AdminController@updateCliente'];
$routes[] = ['/dashboard/delete/cliente/{id}', 'AdminController@deleteCliente'];

return $routes;

