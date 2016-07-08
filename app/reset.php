<?php
include 'functions.php';
include 'inc/head.php';

$link = isset($_GET['link']) ? $_GET['link'] : false;
$time = $_GET['time'];
$userID = isset($_GET['id']) ? $_GET['id'] : "";

if (!$link) {
  $email = $_GET['email'];
  $user = getUserByEmail($email);
  $id = $user['id'];
  $name = $user['f_name'];

  $subject = "DIYMKE Dashboard: Password Reset Requested";

  $url = "localhost:8888/diymke/app/reset.php?link=true&id=" . $id . "&time=" . $time;

  $message = "Hi, " . $name . "\r\n
  A password reset request was recently requested for your account.\r\n
  If this password reset was not requested by you or your administrator, please disregard this message.\r\n
  To reset your password, please visit the following link within one hour of receiving this email:\r\n
  " . $url;

  $headers = 'From: admin@diymke.org' . "\r\n" .
    'Reply-To: admin@diymke.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

  mail($email, $subject, $message, $headers);
  ?>
    <title>Password Reset</title>
  </head>
  <body>
    <?php include 'inc/header.php'; ?>
    <div class='row'>
      <section class='twelve'>
        <p class='lead offset'>
          Password Reset
        </p>
      </section>
    </div>
    <main>
      <div class='row'>
        <div class='eight shift-two'>
          <p>
            An email has been sent to the user.
          </p>
        </div>
      </div>
    </main>
  </body>
  </html>
  <?php
} else if (!isset($_POST['submit'])) {
  if ((time() - $time) < 3600) {
  ?>
    <title>Password Reset</title>
  </head>
  <body>
    <main>
      <div class='row'>
        <div class='eight shift-two'>
          <form action='update-password.php' method='post'>
            <div class='input-field'>
              <label for='newPassword'>New Password: </label>
              <input type='password' name='newPassword' />
            </div>
            <input type='text' name='id' value='<?php echo $_GET['id']; ?>' hidden />
            <input type='submit' name='submit' value='submit' />
          </form>
        </div>
      </div>
    </main>
  </body>
  </html>
  <?php
}}?>
