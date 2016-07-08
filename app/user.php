<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$user = substr($_SESSION['name'], 10, 255);
$info = getUserByEmail($user);
?>
<title>Dashboard | DIYMKE</title>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <div class='eight gray shift-two'>
        <h3>Hello, <?php echo $user; ?></h3>
        <p>Your Profile:</p>
        <ul>
          <li>User ID: <?php echo $info['id']; ?></li>
          <li>Name: <?php echo $info['f_name'] . " " . $info['l_name']; ?></li>
          <li>Email: <?php echo $info['email']; ?></li>
          <li>Last Login: <?php echo $info['last_login']; ?></li>
          <li>Last Login IP: <?php echo $info['login_ip']; ?></li>
        </ul>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
