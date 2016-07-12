<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';
?>
<title>Delete Band</title>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          Delete Band
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='eight shift-two alert red'>
        <?php if (!isset($_GET['confirm'])) {?>
        <h3>Are you sure you want to delete this band?</h3>
        <a href='bands'>No</a><br />
        <a href='delete-band?confirm=true&id=<?php echo $_GET['id']; ?>'>Yes</a>
        <?php } else {
          $result = deleteBand($_GET['id']);
          if ($result) {
        ?>
        <h3>Band Deleted</h3>
        <?php }else {?>
        <h3>Error deleting band</h3>
        <?php }} ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
