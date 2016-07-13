<?php include 'inc/header.php'; ?>
<?php
  $status = $_GET['id'];
  $codes = array(
    403 => '403: Forbidden',
    404 => '404: Not Found',
    405 => '405: Not Allowed',
    408 => '408: Request Timeout',
    500 => '500: Internal Service Error',
    502 => '502: Bad Gateway',
    504 => '504: Gateway Timeout'
  );
echo "
<div class='row'>
<div class='gray twelve'>
  <h1>Error " . $codes[$status] . " </h1>
  <p>Our Team is working to fix this. We're sorry for the inconvenience. If you keep
    experiencing this error, <a href='contact'>Please Contact Us</a></p>
</div>
</div>
</main>";
include 'inc/footer.php';
?>
