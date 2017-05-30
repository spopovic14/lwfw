<?php

$router = new Core\Http\Router($container);



$router->get('', 'HomeController@home');
$router->get('api/:id', 'HomeController@index');



return $router;