<?php
include '../functions.php';

$arr = array(
  'name' => htmlspecialchars($_POST['bandname']),
  'location' => htmlspecialchars($_POST['location']),
  'email' => htmlspecialchars($_POST['email']),
  'music_link' => htmlspecialchars($_POST['music_link']),
  'website_link' => htmlspecialchars($_POST['website']),
  'facebook_link' => htmlspecialchars($_POST['facebook']),
  'description' => htmlspecialchars($_POST['description']),
  'year_established' => htmlspecialchars($_POST['est']),
  'genres' => htmlspecialchars($_POST['genres']),
  'last_update' => time()
);


$res = newBand($arr);

if ($res === TRUE) {
  header('Location: ../submit.php#thanks');
  exit;
} else {
  header('Location: ../submit.php#error');
  exit;
}
?>
