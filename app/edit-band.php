<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$id = isset($_GET['id']) ? $_GET['id'] : "";

$band = getBandPost($id);

$status;

if (isset($_POST['submit'])) {
  $vars = array(
    'name' => $_POST['name'],
    'location' => $_POST['location'],
    'email' => $_POST['email'],
    'music_link' => $_POST['music_link'],
    'website_link' => $_POST['website_link'],
    'facebook_link' => $_POST['facebook_link'],
    'description' => $_POST['description'],
    'year_established' => $_POST['year_established'],
    'genres' => $_POST['genres'],
    'id' => $_GET['id']
  );

  if (updateBand($vars)) {
    $status = true;
  } else {
    $status = false;
  }
}
?>
<title>Edit Band</title>
</head>
<body>
  <?php include 'inc/header.php';?>
  <main>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          Edit Band
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='eight shift-two gray'>
        <?php
        if ($status) {
          ?>
          <div class='alert success'>
            <h3>Success!</h3>
            <p>Entry Updated</p>
          </div>
          <?php
        } else {
          ?>
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>' method='post'>
          <div class='input-field'>
            <label for='name'>Band Name</label>
            <input type='text' name='name' value='<?php if (isset($band)) echo $band['name']; ?>' />
          </div>
          <div class='input-field'>
            <label for='location'>Location</label>
            <input type='text' name='location' value='<?php if (isset($band)) echo $band['location']; ?>' />
          </div>
          <div class='input-field'>
            <label for='email'>Email</label>
            <input type='email' name='email' value='<?php if (isset($band)) echo $band['email']; ?>' />
          </div>
          <div class='input-field'>
            <label for='music_link'>Music Link</label>
            <input type='text' name='music_link' value='<?php if(isset($band)) echo $band['music_link']; ?>' />
          </div>
          <div class='input-field'>
            <label for='website_link'>Website Link</label>
            <input type='text' name='website_link' value='<?php if(isset($band)) echo $band['website_link']; ?>' />
          </div>
          <div class='input-field'>
            <label for='facebook_link'>Facebook Link</label>
            <input type='text' name='facebook_link' value='<?php if(isset($band)) echo $band['facebook_link']; ?>' />
          </div>
          <div class='input-field'>
            <label for='description'>Description</label>
            <textarea name='description'><?php if(isset($band)) echo $band['description']; ?></textarea>
          </div>
          <div class='input-field'>
            <label for='year_established'>Year Established</label>
            <select name='year_established'>
              <?php
                $i;
                $earliestYear = 1999;
                $setYear = isset($band) ? $band['year_established'] : null;
                for ($i = date('Y'); $i > $earliestYear; $i--) {
                  if ($setYear == $i) {
                    echo "<option value=" . $i . " selected>" . $i . "</option>";
                  } else {
                    echo "<option value=" . $i . ">" . $i . "</option>";
                  }
                }
              ?>
              <option value='0000'>1999 &amp; Before</option>
            </select>
          </div>
          <div class='input-field'>
            <label for='genres'>Genres</label>
            <input type='text' name='genres' value='<?php if(isset($band)) echo $band['genres']; ?>' />
          </div>
          <input type='submit' name='submit' value='submit' class='btn' />
        </form>

        <?php } ?>
      </div>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
