<?php

namespace App\Repository;

use Core\Base\Repository;
use Core\Database\Connection;

class UserRepository extends Repository
{
	
    const TABLE_NAME = 'user';
    
    public function getById($id)
    {
        $statement = $this->getDb()->prepare('SELECT id, name FROM ' . static::TABLE_NAME . ' where id = :id');
		$statement->setFetchMode(Connection::FETCH_CLASS, 'App\Model\User');
		$statement->execute([':id' => $id]);
		$user = $statement->fetch();
		if($user == false)
		{
			$user = null;
		}
		return $user;
    }
    
}
