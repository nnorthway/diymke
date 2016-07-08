<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$result;

if (isset($_POST['submit'])) {
  $vars = array(
    'f_name' => $_POST['f_name'],
    'l_name' => $_POST['l_name'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'email' => $_POST['email']
  );

  $result = createUser($vars);
}

if ($result) {
  ?>
  <title>Create User</title>
</head>
<body>
  <?php include 'inc/header.php';?>
  <main>
    <div class='row'>
      <section class='twelve'>
        <p class='lead offset'>
          New User Created
        </p>
      </section>
    </div>
  </main>
</body>
</html>
<?php
} else {

?>
<title>Create User</title>
<script type='text/javascript'>
$(document).ready(function() {
  $("#password-confirm").keyup(function() {
    if ($("#password-confirm").val() != $("#password").val()) {
      $("#message").html('<p>Passwords do not match</p>')
    } else {
      $("#message").html('');
    }
  })
})
</script>
</head>
<body>
  <?php include 'inc/header.php';?>
  <main>
    <div class='row'>
      <div class='eight shift-two'>
        <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='post'>
          <div class='input-field'>
            <label for='f_name'>First Name</label>
            <input type='text' name='f_name' required />
          </div>
          <div class='input-field'>
            <label for='l_name'>Last Name</label>
            <input type='text' name='l_name' required />
          </div>
          <div class='input-field'>
            <label for='email'>Email</label>
            <input type='email' name='email' required />
          </div>
          <div class='input-field'>
            <label for='password'>Password</label>
            <input type='password' name='password' required id='password'/>
          </div>
          <div class='input-field'>
            <label for='password_confirm'>Confirm Password</label>
            <div id='message'></div>
            <input type='password' name='password_confirm' required id='password-confirm' />
          </div>
          <input type='submit' name='submit' value='Create User' />
        </form>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
<?php } ?>
