<?php


namespace controllers\defaultControllers;


class ContactController
{

    /**
     * @POST
     */
    public function index()
    {


        $url = "https://www.google.com/recaptcha/api/siteverify";
        $testUrl = "http://localhost:1234/xampp/algaivel/back/test";

        $privateKey = "6LesQhcTAAAAAAdkFuj5N5-F5TL0hHINIcaWgVRB";

        var_dump($_POST);
        $requestParameters = array(
            'response' => $_POST['g-recaptcha-response'],
            'secret' => $privateKey,
            'remoteip' => $_SERVER['REMOTE_ADDR']

        );

        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $requestParameters,
        );

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $server_output = curl_exec($ch);

        var_dump($server_output);
        if ($server_output) {


            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $nickName = $_POST['nickname'];
            $message = $_POST['message'];

            $to = "ph.kolarov@gmail.com";
            $subject = "Запитване";
            $tеxt = <<<KUF
От:
Относно: $subject
Телефон: $phone
Никнейм: $nickName

Съобщение:
$message

KUF;

            $headers = "From:" . $_POST['email'];
            mail($to, $subject, $tеxt, $headers);

            header("Location: /xampp/algaivel/front/#/contacts?success=true");
            die;

        } else {
            header("Location: /xampp/algaivel/front/#/contacts?success=false");
            die;
        }
    }

}