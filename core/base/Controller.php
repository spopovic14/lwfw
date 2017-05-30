<?php

namespace Core\Base;

class Controller
{

	/**
	 * @var Container
	 */
	protected $container;

	
	public function render($template, $arguments)
	{
		$response = new \Core\Http\HttpResponse($template, $arguments);
		return $response;
	}

	public function json($object)
	{
		$response = new \Core\Http\JsonResponse($object);
		return $response;
	}


	public function setContainer($container)
	{
		$this->container = $container;
	}

	public function getDb()
	{
		return $this->container->get('connection')->getConnection();
	}
	
	public function getRepositoryManager()
    	{
        	return $this->container->get('repositoryManager');
    	}

}
