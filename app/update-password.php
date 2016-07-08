<?php
include 'functions.php';
include 'inc/head.php';
$newPassword = $_POST['newPassword'];
$userID = $_POST['id'];
updatePassword($userID, $newPassword);
?>
<title>Password Reset</title>
</head>
<body>
<main>
  <div class='row'>
    <section class='twelve'>
      <p class='lead offset'>
        Password Reset
      </p>
    </section>
  </div>
  <div class='row'>
    <div class='eight shift-two'>
      <h3>Password Reset</h3>
      <a href='login' title='Log In'>Log In</a>
    </div>
  </div>
</main>
