<?php

namespace Core\Http;

class JsonResponse extends Response
{
	
	public function __construct($object, $content = '', $status = 200)
	{
		parent::__construct($content, $status, ['Content-Type' => 'application/json', 'Connection' => 'Close']);
		$this->setContent(json_encode($object));
	}

}