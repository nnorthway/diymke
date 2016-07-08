<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$res;

if (isset($_GET['id'])) {
  $res = deleteUser($_GET['id']);
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
          Delete User
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='eight shift-two gray'>
        <?php if ($res) {?>
        <div class='alert success'>
          <h3>User Deleted</h3>
        </div>
        <?php } else {?>
        <div class='alert error'>
          <h3>Error: Failed to Delete User</h3>
        </div>
        <?php } ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
