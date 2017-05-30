<?php

namespace Core\Http;

class HttpResponse extends Response
{
	
	public function __construct($template, $arguments = [], $status = 200)
	{
		parent::__construct('', $status, ['Content-Type' => 'text/html']);
		$content = file_get_contents(BASE_DIR . 'resources/templates/' . $template);

		$content = preg_replace_callback('/{{[ ]?([a-zA-Z][a-zA-Z0-9_]*?)[ ]?}}/', 
			function($matches) use ($arguments) {
				if(array_key_exists($matches[1], $arguments)) {
					return $arguments[$matches[1]];
				}
				return '';
			},
			$content
		);

		$this->setContent($content);
	}

}