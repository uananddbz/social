<?php
include('connect.php'); include('fun.php'); include('classes/user_class.php');
$app=new user($db);
require_once __DIR__ . '/vendor/autoload.php';


$fb = new Facebook\Facebook([
  'app_id' => '209689342413048',
  'app_secret' => '19dca080414c053cd47302a18d3e64ec',
  'default_graph_version' => 'v2.2',
  ]);

# login-callback.php

$helper = $fb->getRedirectLoginHelper();
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
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']


// get fb user data
$fb->setDefaultAccessToken( $_SESSION['facebook_access_token'] );

try {
  $response = $fb->get('/me');
  $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$q=$app->signup($userNode['id'],'',$userNode['firstName'],$userNode['lastName'] );

if ($q==1) {
$uid= $userNode['id'];
$data['gender']=$userNode['gender'];
$data['email']=$userNode['email'];

$db->update('members',"username=$uid",$data);
}

$app->login( $userNode['id'],'' );
header("Location: index.php");

}

?>

