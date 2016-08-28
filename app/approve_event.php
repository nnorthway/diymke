<?php
$id = $_GET['id'];

include 'functions.php'; 
if (approveEvent($id)) {
  header('Location: events.php#approved');
  exit;
} else {
  header('Location: events.php#error');
  exit;
}
?>
