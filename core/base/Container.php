<?php

namespace Core\Base;

class Container
{
	
	private $services;


	public function __construct()
	{
		$this->services = [];
	}

	public function get($service)
	{
		if(array_key_exists($service, $this->services))
		{
			return $this->services[$service];
		}
		return null;
	}

	public function addService($name, $service, $override = false)
	{
		if(!$override)
		{
			if(array_key_exists($name, $this->services))
			{
				return false;
			}
		}
		$this->services[$name] = $service;
	}

}