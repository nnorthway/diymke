<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
if (logOut()) {
  header('Location: ../index');
  exit;
} else {
  echo "Error: Could Not End Session.";
}
?>
