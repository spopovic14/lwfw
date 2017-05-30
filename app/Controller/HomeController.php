<?php


/*
 * Example controller
 */

namespace App\Controller;

use Core\Http\JsonResponse;
use Core\Http\HttpResponse;
use Core\Http\Response;
use Core\Http\Request;
use Core\Base\Controller;
use Core\Database\Connection;

use App\Model\User;

class HomeController extends Controller
{

	private $users = ['stefan' => 'sifra1', 'nikola' => 'sifra1'];

	private function authUser()
	{
		$username = Request::getAuthUser();
		$password = Request::getAuthPass();

		if(array_key_exists($username, $this->users) && $this->users[$username] == $password)
		{
			return $username;
		}
		return null;
	}

	public function index($id)
	{
		if($this->authUser() == null)
		{
			return Response::generate401();
		}

		$id = [];
		$obj = ['id' => 5, 'name' => 'ime'];
		array_push($id, $obj);
		return new JsonResponse($obj);
	}

	public function home()
	{
		$rm = $this->getRepositoryManager();
		$user = $rm->getRepository('User')->getById(1);
		return $this->render('home.temp.php', [
			'other' => $user->getName()
		]);
	}

}
