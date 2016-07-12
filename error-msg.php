<?php include 'header.php'; ?>
<?php
  $status = $_SERVER['REDIRECT_STATUS'];
  $codes = array(
    403 => '403: Forbidden',
    404 => '404: Not Found',
    405 => '405: Not Allowed',
    408 => '408: Request Timeout',
    500 => '500: Internal Service Error',
    502 => '502: Bad Gateway',
    504 => '504: Gateway Timeout'
  );
?>
<div class='row'>
<div class='gray twelve'>
  <h1>Error <?php echo $codes[$status]; ?></h1>
  <p>Our Team is working to fix this. We're sorry for the inconvenience. If you keep
    experiencing this error, <a href='contact'>Please Contact Us</a></p>
</div>
</div>
</main>
<?php include 'footer.php'; ?>
