<?php
namespace controllers\defaultControllers;

use Repositories\GalleryRepository;
use Repositories\UsersRepository;

class AdminController {

	public function index($params) {

		$data = file_get_contents('php://input');
		$data = json_decode($data);
		$data = json_decode($data->data);

		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();
		echo $data->sessionId; 
		if( $data->sessionId == $userOutputObject->session && $data->id == $userOutputObject->fb_id ){

			$galleryRepo = GalleryRepository::create();
			$gallery = $galleryRepo->filterBySource($data->element)->findOne();
			$galleryOutputObject = $gallery->FullObjectGeter();
			$source = $galleryOutputObject->source;

			var_dump($source);

			$link = mysqli_connect("localhost", "root", "", "algaivel");
			$sql = "UPDATE gallery SET carousel=0 WHERE source='$source'";
			$link->query($sql);



		}

	}

}

?>