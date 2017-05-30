<?php

namespace Core\Database;

class Connection
{
	
	protected $connection;

	const FETCH_ASSOC = \PDO::FETCH_ASSOC;
	const FETCH_CLASS = \PDO::FETCH_CLASS;


	public function init()
	{
		if(!isset($this->connection))
		{
			$this->connection = new \PDO(DRIVER . ':host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
		}
	}

	public function getConnection()
	{
		$this->init();
		return $this->connection;
	}

}