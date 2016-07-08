<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';
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
    <div class='row'>
      <div class='eight shift-two'>
        <table>
          <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
          </thead>
          <tbody>
            <?php getUsers(); ?>
          </tbody>
          <tfoot>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tfoot>
        </table>
        <a href='new-user' class='btn'>Create User</a>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
