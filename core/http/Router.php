<?php

namespace Core\Http;

class Router
{

	protected $container;
	
	protected $routes = [
		'GET' => [],
		'POST' => [],
		'PUT' => [],
		'DELETE' => [],
		'ANY' => []
	];

	protected $patterns = [
		':id' => '([0-9]+)'
	];



	public function __construct($container)
	{
		$this->container = $container;
	}


	public function any($path, $handler)
	{
		$this->addRoute('ANY', $path, $handler);
	}

	public function get($path, $handler)
	{
		$this->addRoute('GET', $path, $handler);
	}

	public function put($path, $handler)
	{
		$this->addRoute('PUT', $path, $handler);
	}

	public function post($path, $handler)
	{
		$this->addRoute('POST', $path, $handler);
	}

	public function delete($path, $handler)
	{
		$this->addRoute('DELETE', $path, $handler);
	}


	protected function addRoute($method, $path, $handler)
	{
		array_push($this->routes[$method], [$path => $handler]);
	}


	protected function replaceWildcards($url)
	{
		foreach($this->patterns as $wildcard => $pattern)
		{
			$url = str_replace($wildcard, $pattern, $url);
		}

		return $url;
	}

	protected function callHandler($handler, $matches)
	{
		if(!is_string($handler)) {
			return call_user_func_array($handler, $matches);
		}

		$array = explode('@', $handler);
		$controller = "App\\Controller\\" . $array[0];
		$action = $array[1];

		$controller = new $controller;
		if(!method_exists($controller, $action))
		{
			throw new Exception("Action {$action} doesn\'t exist in {$controller}");
		}

		$controller->setContainer($this->container);
		return call_user_func_array([$controller, $action], $matches);
	}



	public function handle($method, $url)
	{
		foreach($this->routes[$method] as $entry)
		{
			$route = array_keys($entry)[0];
			$handler = $entry[$route];

			$pattern = '#^' . $this->replaceWildcards($route) . '$#';
			$result = preg_match($pattern, $url, $matches);

			if($result)
			{
				array_shift($matches);
				return $this->callHandler($handler, $matches);
			}
		}

		return Response::generate404();
	}

}