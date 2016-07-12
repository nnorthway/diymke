<?php

include 'functions.php';

$conn = conn();

$email = isset($_POST['email']) ? $_POST['email'] : null;
$pass = isset($_POST['password']) ? $_POST['password'] : null;

if (isset($_POST['submit'])) {
  if (logIn($email, $pass)) {
    session_start();
    $_SESSION['name'] = "DASHBOARD " . $email;
    header('Location: index');
    exit;
  }
}
if (!logIn($email, $pass)) {
include 'inc/head.php';
?>
  <title>Log In | DIYMKE</title>
</head>
<body>
  <main class='row'>
    <div class='eight shift-two gray'>
      <h2>Log In</h2>
      <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
        <div class='input-field'>
          <label for='email'>Email Address</label>
          <input type='email' name='email' value='<?php echo $email; ?>' required />
        </div>
        <div class='input-field'>
          <label for='password'>Password</label>
          <input type='password' name='password' value='' required />
        </div>
        <input type='submit' name='submit' value='submit' />
        <a href='reset.php?email=<?php echo $email; ?>&time=<?php echo time(); ?>'>Forgot Password</a>
      </form>
    </div>
  </main>
</body>
<?php } ?>
