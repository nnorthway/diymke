<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$userID = isset($_GET['id']) ? $_GET['id'] : "";

$user = getUser($userID);

$status;

if (isset($_POST['submit'])) {
  $vars = array(
    'id' => $_POST['id'],
    'f_name' => $_POST['f_name'],
    'l_name' => $_POST['l_name'],
    'email' => $_POST['email']
  );

  if (updateUser($vars)) {
    $status = true;
  } else {
    $status = false;
  }
}
?>
<title>Users | DIYMKE</title>
</head>
<body>
  <?php include 'inc/header.php';?>
  <main>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          User Management
        </p>
      </section>
    </div>
        <?php
        if ($status) {
          ?>
          <div class='row'>
            <div class='eight shift-two gray'>
              <div class='alert success'>
                <h3>Success!</h3>
                <p>User Profile Updated</p>
              </div>
            </div>
          </div>
          <?php
        } else {?>
    <div calss='row'>
      <div class='eight shift-two'>
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
          <div class='input-field'>
            <label for='f_name'>First Name</label>
            <input type='text' name='f_name' value='<?php echo $user['f_name']; ?>' />
          </div>
          <div class='input-field'>
            <label for='l_name'>Last Name</label>
            <input type='text' name='l_name' value='<?php echo $user['l_name']; ?>' />
          </div>
          <div class='input-field'>
            <label for='email'>Email</label>
            <input type='text' name='email' value='<?php echo $user['email']; ?>' />
          </div>
          <a href="reset.php?id=<?php echo urlencode($user['id']); ?>&time=<?php echo time(); ?>">Reset Password</a>
          <input type='text' name='id' value='<?php echo $user['id']; ?>' hidden />
          <br /><br /><input type='submit' name='submit' value='Update User' />
        </form>
        <?php } ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
