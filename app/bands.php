<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';
?>
<title>Bands</title>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          Bands
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='eight shift-two'>
        <?php getBands(); ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
