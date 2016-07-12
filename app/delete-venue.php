<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';
?>
<title>Delete Venue</title>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <section class='twelve'>
        <p class='lead offset'>
          Delete Venue
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='eight shift-two gray'>
        <?php if (!isset($_GET['confirm'])) {?>
        <h3>Are you sure you want to delete this Venue?</h3>
        <a href='venues'>No</a><br />
        <a href='delete-venue.php?confirm=true&id=<?php echo $_GET['id']; ?>'>Yes</a>
        <?php } else {
          $result = deleteVenue($_GET['id']);
          if ($result) {
        ?>
        <h3>Venue Deleted</h3>
        <?php }else {?>
        <h3>Error deleting Venue</h3>
        <?php }} ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
