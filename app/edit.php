<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$postID = isset($_GET['id']) ? $_GET['id'] : "";

$status;

if (isset($_POST['submit'])) {
  $vals = array(
    'postID' => $postID,
    'postTitle' => $_POST['postTitle'],
    'postDesc' => $_POST['postDesc'],
    'postCont' => $_POST['postCont']
  );
  if (updatePost($vals)) {
    $status = true;
  }
}

$post = getPost($postID);


?>
<title>Edit | DIYMKE</title>
<script>
  tinymce.init({
    selector: 'textarea'
  });
</script>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <section class='twelve'>
        <p class='lead offset'>
          Edit Post
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='eight shift-two'>
        <?php
        if ($status) {?>
          <div class='alert success'>
            <h3>Success!</h3>
            <p>The post has been updated</p>
          </div>
        <?php } else {?>
        <div class='editor'>
          <form action='<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $postID;?>' method='post'>
            <div class='input-field'>
              <label for='postTitle'>Title</label>
              <input type='text' name='postTitle' value='<?php echo $post['postTitle']; ?>' />
            </div>
            <div class='input-field'>
              <label for='postDesc'>Description</label>
              <textarea name='postDesc'>
                <?php echo $post['postDesc']; ?>
              </textarea>
            </div>
            <div class='input-field'>
              <label for='postCont'>Content</label>
              <textarea name='postCont'>
                <?php echo $post['postCont']; ?>
              </textarea>
            </div>
            <input type='text' name='postID' value='<?php echo $postID; ?>' hidden />
            <input type='text' name='postDate' value='<?php echo $post['postDate']; ?>' hidden />
            <input type='submit' name='submit' value='Update Post' />
          </form>
        </div>
        <?php } ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
