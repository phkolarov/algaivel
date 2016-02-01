<?php

session_start();

require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1664655443803322',
  'app_secret' => '0541f62368f74f8337f2657c7c1ca423',
  'default_graph_version' => 'v2.5'
]);

$helper = $fb->getJavaScriptHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  
   $fb->setDefaultAccessToken($accessToken);

  try {
  
    $requestProfile = $fb->get("/me?fields=name,email,id");
    $profile = $requestProfile->getGraphNode()->asArray();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
  }

  print_r(json_encode([$profile['name'], $profile['email']]));

  /*setcookie("facebookName", $profile['name'], time() * (3600 * 2),  "/php/");
  setcookie("facebookName", $profile['id'], time() * (3600 * 2),  "/php/");
  $_COOKIE["facebookId"] = $profile['name'];
  $_COOKIE["facebookId"] = $profile['id'];*/

  //header('location: ../');
  exit;
} else {
    echo "Unauthorized access!!!";
    exit;
}
