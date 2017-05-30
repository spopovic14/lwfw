<?php

namespace Core\Http;

class Response
{

	private $statusCode;
	private $statusText;
	private $content;
	private $header = [];
	private $headersSent = False;
	private $protocolVersion;


	public static $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    );


	public function __construct($content = '', $status = 200, $headers = [])
	{
		$this->header = $headers;
		$this->setContent($content);
		$this->setStatusCode($status);
		$this->setProtocolVersion('1.0');

		if(!$this->hasHeaderValue('Date'))
		{
			$this->setDate(\DateTime::createFromFormat('U', time()));
		}
	}


	protected function sendContent()
	{
		echo $this->content;
	}

	protected function sendHeaders()
	{
		if($this->headersSent)
		{
			return $this;
		}

		if(!$this->hasHeaderValue('Date'))
		{
			$this->setDate(\DateTime::createFromFormat('U', time()));
		}

		foreach($this->header as $name => $value)
		{
			header($name . ':' . $value, false, $this->statusCode);
		}

		header(sprintf('HTTP%s %s %s', $this->protocolVersion, $this->statusCode, $this->statusText), true, $this->statusCode);
	}

	protected function prepare()
	{
		if(Request::getProtocol() != 'HTTP/1.0')
		{
			$this->setProtocolVersion('1.1');
		}

		if(Request::getMethod() == 'HEAD')
		{
			$this->setContent('');
		}

		if($this->getProtocolVersion() == '1.0' && strpos($this->header['Cache-control'], 'no-cache') !== false)
		{
			$this->header['pragma'] = 'no-cache';
			$this->header['expires'] = -1;
		}
	}

	public function send()
	{
		$this->prepare();
		$this->sendHeaders();
		$this->sendContent();
	}


	public function getProtocolVersion()
	{
		return $this->protocolVersion;
	}

	protected function hasHeaderValue($key)
	{
		return array_key_exists($key, $this->header);
	}


	public function setProtocolVersion($ver)
	{
		$this->protocolVersion = $ver;
	}

	public function setStatusCode($code, $text = null)
	{
		if($text == null)
		{
			$this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'unknown status';
		}
		$this->statusCode = $code;
	}

	public function setContent($content)
	{
		$this->content = $content;
		if(!is_string($content))
		{
			throw new Exception('Response content must be a string');
		}
	}

	public function setDate(\DateTime $date)
	{
		$date->setTimezone(new \DateTimeZone('UTC'));
		$this->header['Date'] = $date->format('D, d M Y H:i:s') .  ' GMT';
	}


	public static function generate404()
	{
		$content = '
			<html>
				<head>
					<title>404 Not Found</title>
					<style>
						h1 {
							font-size: 4em;
							margin: 0 auto;
						}
						p {
							font-size: 2em;
							margin: 0 auto;
						}
					</style>
				</head>
				<body>
					<h1>404 Not Found</h1>
					<p>This page could not be found on the server.</p>
				</body>
			</html>
		';
		$response = new static($content, 404);
		return $response;
	}

	public static function generate500()
	{
		$content = '
			<html>
				<head>
					<title>500 Internal Server Error</title>
					<style>
						h1 {
							font-size: 4em;
							margin: 0 auto;
						}
						p {
							font-size: 2em;
							margin: 0 auto;
						}
					</style>
				</head>
				<body>
					<h1>500 Internal Server Error</h1>
					<p>Oops, something went wrong!</p>
				</body>
			</html>
		';
		$response = new static($content, 500);
		return $response;
	}

	public static function generate401()
	{
		$content = '
			<html>
				<head>
					<title>401 Unauthorized</title>
					<style>
						h1 {
							font-size: 4em;
							margin: 0 auto;
						}
					</style>
				</head>
				<body>
					<h1>401 Unauthorized</h1>
				</body>
			</html>
		';
		$response = new static($content, 401);
		return $response;
	}

}