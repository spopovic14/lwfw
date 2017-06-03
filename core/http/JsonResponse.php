<?php

namespace Core\Http;

use Core\Base\Model;

class JsonResponse extends Response
{
	
	public function __construct($object, $content = '', $status = 200)
	{
		parent::__construct($content, $status, ['Content-Type' => 'application/json', 'Connection' => 'Close']);
		if($object instanceof Model)
		{
			$object = $object->toArray();
		}
		$this->setContent(json_encode($object));
	}

}
