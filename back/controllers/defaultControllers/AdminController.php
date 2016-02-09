<?php
namespace controllers\defaultControllers;

use Repositories\GalleryRepository;
use Repositories\ArticlesRepository;
use Repositories\UsersRepository;


class AdminController {

	public function index($params) {

		$data = file_get_contents('php://input');
		$data = json_decode($data);

		if( !isset($data->sessionId) ){
			exit();
		}

		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();

		if( $data->sessionId == $userOutputObject->session && $data->id == $userOutputObject->fb_id ){

			foreach ($data->elements as $key => $value) {

				$galleryRepo = GalleryRepository::create();
				$gallery = $galleryRepo->filterBySource($value)->findOne();
				$galleryOutputObject = $gallery->FullObjectGeter();
				$source = $galleryOutputObject->source;
				$link = mysqli_connect("localhost", "root", "", "algaivel");
				$sql = "UPDATE gallery SET carousel=0 WHERE source='$source'";
				$link->query($sql);

			}
			
		}

	}

	public function postArticle($params) {

		$data = file_get_contents('php://input');
		$data = json_decode($data);

		if( !isset($data->sessionId) ){
			exit();
		}
		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();

		if( $data->sessionId == $userOutputObject->session && $data->id == $userOutputObject->fb_id ){
	
			$articleRepo = ArticlesRepository::create();
			$article = $articleRepo->filterByTitleBg($data->titleBg)->findOne();
			$articleOutputObject = $article->FullObjectGeter();

			$articleEn = $articleRepo->filterByTitle($data->titleEn)->findOne();
			$articleOutputObjectEn = $articleEn->FullObjectGeter();

			if( $articleOutputObject->title == NULL && $articleOutputObjectEn->title == NULL ){

				$link = mysqli_connect("localhost", "root", "", "algaivel");
				$sql = "INSERT INTO articles SET titleBg='$data->titleBg',contentBg='$data->descBg',articleImage='$data->image',title='$data->titleEn',content='$data->descEn'";
				$link->query($sql);

			}else{
					
				echo 'Article with the same title already exist!';

			}

			

			
			
			/*if( $articleOutputObject-> != NULL ){

				$link = mysqli_connect("localhost", "root", "", "algaivel");
				$sql = "UPDATE articles SET carousel=0 WHERE source='$source'";
				$link->query($sql);

			}*/

		}

	}

	public function editArticle() {

		$data = file_get_contents('php://input');
		$data = json_decode($data);

		if( !isset($data->sessionId) ){
			exit();
		}
		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();

		if( $data->sessionId == $userOutputObject->session && $data->fbid == $userOutputObject->fb_id ){
			var_dump($data->image);
			$link = mysqli_connect("localhost", "root", "", "algaivel");
			$sql = "UPDATE articles SET
										titleBG='$data->titleBg',
										contentBG='$data->descBg',
										articleImage='$data->image',
										content='$data->descEn',
										title='$data->titleEn'
									WHERE id='$data->id'";
			$link->query($sql);


		}

	}

	public function removeArticle() {

		$data = file_get_contents('php://input');
		$data = json_decode($data);
		
		if( !isset($data->sessionId) ){
			exit();
		}
		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();

		if( $data->sessionId == $userOutputObject->session && $data->id == $userOutputObject->fb_id ){

			$link = mysqli_connect("localhost", "root", "", "algaivel");
			$sql = "DELETE FROM articles WHERE id='$data->elId'";
			$link->query($sql);

		}

	}

	public function addToCarousel(){

		$data = file_get_contents('php://input');
		$data = json_decode($data);

		if( !isset($data->sessionId) ){
			exit();
		}

		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();

		if( $data->sessionId == $userOutputObject->session && $data->id == $userOutputObject->fb_id ){

			foreach ($data->elements as $key => $value) {

				$galleryRepo = GalleryRepository::create();
				$gallery = $galleryRepo->filterBySource($value)->findOne();
				$galleryOutputObject = $gallery->FullObjectGeter();

				$source = $galleryOutputObject->source;

				$link = mysqli_connect("localhost", "root", "", "algaivel");
				$sql = "UPDATE gallery SET carousel=1 WHERE source='$source'";
				$link->query($sql);

			}
			
		}

	}

	public function removeImage() {

		$data = file_get_contents('php://input');
		$data = json_decode($data);

		if( !isset($data->sessionId) ){
			exit();
		}
		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();

		if( $data->sessionId == $userOutputObject->session && $data->id == $userOutputObject->fb_id ){

			foreach ($data->elements as $key => $value) {

				$galleryRepo = GalleryRepository::create();
				$gallery = $galleryRepo->filterBySource($value)->findOne();
				$galleryOutputObject = $gallery->FullObjectGeter();

				$source = $galleryOutputObject->source;
				$id = $galleryOutputObject->id;

				$link = mysqli_connect("localhost", "root", "", "algaivel");
				$sql = "DELETE FROM gallery_categories WHERE gallery_id='$id'";
				$link->query($sql);

				$link = mysqli_connect("localhost", "root", "", "algaivel");
				$sql = "DELETE FROM gallery_tags WHERE gallery_id='$id'";
				$link->query($sql);

				$link = mysqli_connect("localhost", "root", "", "algaivel");
				$sql = "DELETE FROM gallery WHERE source='$source'";
				$link->query($sql);

			}

		}

	}

	public function getCurrentImage(){


		$data = file_get_contents('php://input');
		$data = json_decode($data);

		$galleryRepo = GalleryRepository::create();
		$gallery = $galleryRepo->filterById($data->id)->findOne();
		$galleryOutputObject = $gallery->FullObjectGeter();

		print_r(json_encode(['Ok' ,$galleryOutputObject]));

	}

	public function editImage() {

		$data = file_get_contents('php://input');
		$data = json_decode($data);

		if( !isset($data->sessionId) ){
			exit();
		}

		$usersRepo = UsersRepository::create();
		$user = $usersRepo->filterBySession($data->sessionId)->findOne();
		$userOutputObject = $user->FullObjectGeter();

		if( $data->sessionId == $userOutputObject->session && $data->id == $userOutputObject->fb_id ){
			
			$link = mysqli_connect("localhost", "root", "", "algaivel");
			$sql = "UPDATE gallery  SET titleBG='$data->titleBg',
										descriptionBG='$data->descBg',
										description='$data->desc',
										title='$data->title'
									WHERE id='$data->imageId'";
			$link->query($sql);
			
		}

	}

}

?>