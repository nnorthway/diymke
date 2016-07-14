<?php
//get the recaptcha library
require_once 'recaptchalib.php';
include '../functions.php';

$secretKey = "6LdziiITAAAAAM3xugs_Z67v33mx54ivbO6Wf6fy";

$response = null;

$reCaptcha = new ReCaptcha($secretKey);

if ($_POST['g-recaptcha-response']) {
  $response = $reCaptcha->verifyResponse(
    $_SERVER['REMOTE_ADDR'],
    $_POST['g-recaptcha-response']
  );
}

if ($response != null && $response->success) {
  //handle the form
  $user = array(
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'subject' => $_POST['subject'],
    'message' => wordwrap($_POST['message'], 70, "\r\n")
  );

  contact($user);
  header('Location: ../contact.php#thanks');
  exit;
} else {
  //redirect, spit out that young error message
  header('Location: ../contact.php#captcha_error');
  exit;
}
?>
