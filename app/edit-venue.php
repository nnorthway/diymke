<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';

$id = isset($_GET['id']) ? $_GET['id'] : "";

$venue = getVenuePost($id);

$status;

if (isset($_POST['submit'])) {
  $vars = array(
    'name' => $_POST['name'],
    'location' => $_POST['location'],
    'email' => $_POST['email'],
    'website_link' => $_POST['website_link'],
    'facebook_link' => $_POST['facebook_link'],
    'description' => $_POST['description'],
    'year_established' => $_POST['year_established'],
    'genres' => $_POST['genres'],
    'id' => $_GET['id']
  );

  if (updateVenue($vars)) {
    $status = true;
  } else {
    $status = false;
  }
}
?>
<title>Edit Venue</title>
</head>
<body>
  <?php include 'inc/header.php';?>
  <main>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          Edit Venue
        </p>
      </section>
    </div>
        <?php
        if ($status) {
          ?>
          <div class='row'>
            <div class='eight shift-two gray'>
              <div class='alert success'>
                <h3>Success!</h3>
                <p>Entry Updated</p>
              </div>
            </div>
          </div>
          <?php
        } else {
          if (isset($_POST['submit']) && !$status) {?>
          <div class='row'>
            <div class='eight shift-two gray'>
              <div class='alert warning'>
                <h3>Oh no!</h3>
                <p>We couldn't update this listing at this time. <br /> We're working on fixing this issue!</p>
              </div>
            </div>
          </div>
          <?php
        }
        ?>
    <div class='row'>
      <div class='eight shift-two'>
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>' method='post'>
          <div class='input-field'>
            <label for='name'>Venue Name</label>
            <input type='text' name='name' value='<?php if (isset($venue)) echo $venue['name']; ?>' />
          </div>
          <div class='input-field'>
            <label for='location'>Location</label>
            <input type='text' name='location' value='<?php if (isset($venue)) echo $venue['location']; ?>' />
          </div>
          <div class='input-field'>
            <label for='email'>Email</label>
            <input type='email' name='email' value='<?php if (isset($venue)) echo $venue['email']; ?>' />
          </div>
          <div class='input-field'>
            <label for='music_link'>Music Link</label>
            <input type='text' name='website_link' value='<?php if(isset($venue)) echo $venue['website_link']; ?>' />
          </div>
          <div class='input-field'>
            <label for='facebook_link'>Facebook Link</label>
            <input type='text' name='facebook_link' value='<?php if(isset($venue)) echo $venue['facebook_link']; ?>' />
          </div>
          <div class='input-field'>
            <label for='description'>Description</label>
            <textarea name='description'><?php if(isset($venue)) echo $venue['description']; ?></textarea>
          </div>
          <div class='input-field'>
            <label for='year_established'>Year Established</label>
            <select name='year_established'>
              <?php
                $i;
                $earliestYear = 1999;
                $setYear = isset($venue) ? $venue['year_established'] : null;
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
            <input type='text' name='genres' value='<?php if(isset($venue)) echo $venue['genres']; ?>' />
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
