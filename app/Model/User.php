<?php

/*
 * Example model
 */

namespace App\Model;

use Core\Base\Model;
use Core\Database\Connection;

class User extends Model
{

	protected $id;
	protected $name;

	const TABLE_NAME = 'user';


	public static function getById($connection, $id)
	{
		$statement = $connection->prepare('SELECT id, name FROM ' . User::TABLE_NAME . ' where id = :id');
		$statement->setFetchMode(Connection::FETCH_CLASS, static::class);
		$statement->execute([':id' => $id]);
		$user = $statement->fetch();
		if($user == false)
		{
			$user = null;
		}
		return $user;
	}


	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}
	
}