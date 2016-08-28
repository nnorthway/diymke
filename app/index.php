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
      <div class='error-msg green six shift-three' id='success'>
        <h3>Success</h3>
        <p>
          All old events have been cleared
        </p>
      </div>
      <div class='error-msg red six shift-three' id='error'>
        <h3>Error</h3>
        <p>
          Oops. There was an error. Give that another shot.
        </p>
      </div>
    </div>
    <div class='row'>
      <h3>Hello, <?php echo $user; ?></h3>
    </div>
    <div class='row'>
      <div class='six gray'>
        <h3>New Events | <a href='clear-events.php' class='btn'>Delete Old Events<i class='material-icons'>keyboard_arrow_right</i></a></h3>
        <ul>
        <?php
        $res = getUnmoderatedEvents();
        while ($row = $res->fetch_assoc()) {
          ?>
          <li><a href='edit-event.php?id="<?php echo $row['id']; ?>"'><?php echo $row['name']; ?></a></li>
          <?php
        }
        ?>
        </ul>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
