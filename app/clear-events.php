<?php
include 'functions.php';

if (clearEvents()) {
  header('Location: index.php#success');
  exit;
} else {
  header('Location: index.php#error');
  exit;
}
?>
