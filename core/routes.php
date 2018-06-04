<?php

$routes[] = ['/', 'HomeController@index'];
$routes[] = ['/index', 'HomeController@index'];
$routes[] = ['/index/login', 'HomeController@login'];
$routes[] = ['/index/login/verificar', 'HomeController@verificaLogin'];
$routes[] = ['/index/cadastro', 'HomeController@indexCadastro'];
$routes[] = ['/index/cadastro/cliente', 'HomeController@cadastroCliente'];

$routes[] = ['/admin', 'AdminController@index'];
$routes[] = ['/admin/produtos', 'AdminController@produto'];
$routes[] = ['/admin/cadastro/produto', 'AdminController@viewCadastroProduto'];
$routes[] = ['/admin/cadastro/produto/enviar', 'AdminController@cadastroProduto'];
$routes[] = ['/dashboard/listar/clientes', 'AdminController@listarCliente'];
$routes[] = ['/dashboard/alterar/cliente/{id}', 'AdminController@editarCliente'];
$routes[] = ['/dashboard/update/cliente', 'AdminController@updateCliente'];
$routes[] = ['/dashboard/delete/cliente/{id}', 'AdminController@deleteCliente'];

return $routes;

