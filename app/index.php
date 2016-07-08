<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$user = substr($_SESSION['name'], 10, 255);
?>
<title>Dashboard | DIYMKE</title>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <section class='twelve'>
        <p class='lead offset'>
          Dashboard
        </p>
      </section>
    </div>
    <div class='row'>
      <h3>Hello, <?php echo $user; ?></h3>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
