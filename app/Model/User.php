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
