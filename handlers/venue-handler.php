<?php
include 'functions.php';

$address = $_POST['address_l1'] . "\r\n" . $_POST['address_l2'] . "\r\n" . $_POST['city'] . ", Wisconsin";

$arr = array(
  'name' => htmlspecialchars($_POST['venue_name']),
  'location' => htmlspecialchars($address),
  'email' => htmlspecialchars($_POST['email']),
  'website_link' => htmlspecialchars($_POST['website']),
  'description' => htmlspecialchars($_POST['description']),
  'facebook_link' => htmlspecialchars($_POST['facebook']),
  'year_established' => htmlspecialchars($_POST['est']),
  'genres' => htmlspecialchars($_POST['genres']),
  'last_update' => time()
);

$res = newVenue($arr);

if ($res === TRUE) {
  header('Location: submit.php#thanks');
  exit;
} else {
  header('Location: submit.php#error');
  exit;
}
?>
