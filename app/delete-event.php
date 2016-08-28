<?php
include 'functions.php';
$id = $_GET['id'];
if (deleteEvent($id)) {
  header('Location: events.php#success');
  exit;
} else {
  header('Location: events.php#error');
  exit;
}
?>
