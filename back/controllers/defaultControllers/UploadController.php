<?php

namespace controllers\defaultControllers;

use Repositories\UsersRepository;

class uploadController
{

    public function index()
    {

        if (isset($_POST['session_id']) && isset($_POST['id']))

            $usersRepo = UsersRepository::create();
        $user = $usersRepo->filterBySession($_POST['session_id'])->findOne();
        $userOutputObject = $user->FullObjectGeter();

        if ($_POST['session_id'] == $userOutputObject->session && $_POST['id'] == $userOutputObject->fb_id) {

            if (isset($_FILES['image'])) {

                $title = $_POST['title'];
                $description = $_POST['description'];
                $session_id = $_POST['session_id'];
                $fb_id = $_POST['id'];

                $errors = array();
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file = $_FILES['image']['name'];
                $file_ext = strtolower(end(explode('.', $file)));

                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, "C:/xa/htdocs/test/front/images/" . $file_name);
                    echo "Success";
                } else {
                    print_r($errors);
                }

                $link = mysqli_connect("localhost", "root", "", "algaivel");
                $sql = "INSERT INTO gallery SET source='$file_name',title='$title',description='$description'";
                $link->query($sql);

                header('Location: http://localhost/test/front/#/adminPanel/uploadImage/');

            }
        }
    }
}

?>