<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';
?>
<title>Venues</title>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          Venues
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='eight shift-two'>
        <?php getVenues(); ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
