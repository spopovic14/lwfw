<?php

require '../core/config.php';

require '../autoloader.php';

$container = require '../core/di.php';

$router = require '../core/routes.php';


$response = $router->handle(Core\Http\Request::getMethod(), Core\Http\Request::getUrl());

if(!$response instanceof Core\Http\Response)
{
	throw new Exception('Routes must resturn a Response object');
}

$response->send();
