<?php include 'header.php'; ?>
<main>
  <div class='row'>
    <div class='error-msg twelve'>
<?php
  $status = $_SERVER['REDIRECT_STATUS'];
  if ($status === 200) {echo "Document has been processed and sent to you";}
  if ($status === 400) {echo "Bad HTTP request";}
  if ($status === 401) {echo "Unauthorized - Invalid password";}
  if ($status === 403) {echo "Forbidden";}
  if ($status === 418) {echo "I don't know why this is here";}
  if ($status === 500) {echo "Internal Server Error";}
  ?>
</div>
</div>
<?php include 'footer.php'; ?>
