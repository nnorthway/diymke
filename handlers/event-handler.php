<?php
include '../functions.php';

$file = '';
$url = '';
$valid_file = false;
$fileURL = '';
//verify file type & size
if ($_FILES['event_image']['name']) {
  if (!$_FILES['event_image']['error']) {
    $new_file_name = strtolower($_FILES['event_image']['name']);
    $fileURL = '../uploaded/' . basename($new_file_name);
    if ($_FILES['event_image']['size'] > (1024000)) {
      header('Location: ../submit.php#file_size_limit');
      exit;
    }
    $type = $_FILES['event_image']['type'];
    if (
      $type != 'image/gif' &&
      $type != 'image/jpeg' &&
      $type != 'image/jpg' &&
      $type != 'image/pjpeg' &&
      $type != 'image/png'
    ) {
      header('Location: ../submit.php#file_type');
      exit;
    }
    move_uploaded_file($_FILES['event_image']['tmp_name'], $fileURL);
    $file = $new_file_name;
  }
}
//verify all other information
$address = $_POST['address_l1'] . "\r\n " . $_POST['address_l2'] . "\r\n " . $_POST['city'] . ", Wisconsin";

$eventType = str_replace('_', ' ', $_POST['event_type']);

$arr = array(
  'name' => htmlspecialchars($_POST['event_name']),
  'venue_name' => htmlspecialchars($_POST['event_venue']),
  'venue_address' => strlen($address) > 0 ? htmlspecialchars($address) : null,
  'venue_link' => strlen($_POST['venue_link']) > 0 ? htmlspecialchars($_POST['venue_link']) : null,
  'fb_event' => strlen($_POST['facebook_event']) > 0 ? htmlspecialchars($_POST['facebook_event']) : null,
  'other_event' => strlen($_POST['other_link']) > 0 ? htmlspecialchars($_POST['other_link']) : null,
  'image' => strlen($file) > 0 ? $file : '',
  'cover_charge' => strlen($_POST['cover_charge']) > 0 ? htmlspecialchars($_POST['cover_charge']) : null,
  'date' => htmlspecialchars($_POST['date']),
  'start_time' => htmlspecialchars($_POST['start_time']),
  'event_type' => htmlspecialchars($eventType),
  'age_restriction' => htmlspecialchars($_POST['age_restriction']),
  'description' => strlen($_POST['description']) > 0 ? htmlspecialchars($_POST['description']) : null,
  'host_email' => htmlspecialchars($_POST['host_email'])
);

//add to the database
$res = addEvent($arr);

if ($res) {
  header('Location: ../submit.php#thanks');
  exit;
} else {
  header('Location: ../submit.php#error');
  exit;
}

//redirect

?>
