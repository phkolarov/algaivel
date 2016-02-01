<?php

namespace controllers\defaultControllers;

use Repositories\UsersRepository;
use Models\User;

class UsersController{

	public function index($params){

		if( !isset($_POST['data']) ){

			$data = file_get_contents('php://input');
			$data = json_decode($data);

			if( $data->data->username == 'zhivko' && $data->data->id == '10153885240913377' ){

				$link = mysqli_connect("localhost", "root", "", "algaivel");

				$username = mysqli_real_escape_string($link, $data->data->username);
				$password = mysqli_real_escape_string($link, $data->data->password);

				$usersRepo = UsersRepository::create();
				$user = $usersRepo->filterByUsername($username)->findOne();
				$userOutputObject = $user->FullObjectGeter();

				if( $username == $userOutputObject->username && $password == $userOutputObject->password ){

					$session = $this->session();
					$sql = "UPDATE users SET session='$session' WHERE username='$username'";
					$link->query($sql);

					print_r(json_encode(['Ok' ,$userOutputObject->role_id, $session, $userOutputObject->username]));

				}else{
					echo 'Wrong Credentials!';
				}

			}

		}

	}

	public function logout() {

	}

	public function isAdmin($params) {

		/*$data = file_get_contents('php://input');
		$data = json_decode($data);*/

		if( isset($_POST['data'])){

			$link = mysqli_connect("localhost", "root", "", "algaivel");

			$data = json_decode($_POST['data']);
			$id = mysqli_real_escape_string($link, $data->id);

			$usersRepo = UsersRepository::create();
			$user = $usersRepo->filterByFb_id($id)->findOne();
			$userOutputObject = $user->FullObjectGeter();

			if( $userOutputObject->fb_id != NULL ){

				echo json_encode('admin');

			}else{
				echo json_encode('user');
			}
			
		}else{
			
		}

	}

	public function session() {

		$characters = 's0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 32; $i++) {
			if($i == 9 || $i == 14 || $i == 19 || $i == 24){
				$randomString .= '-';
			}else{
		    	$randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		}

		return $randomString;

	}

}

?>