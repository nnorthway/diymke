<?php
include 'inc/header.php';
include 'functions.php';

$table = $_POST['table'];
$term = $_POST['term'];
$fields = $_POST['genre'];

  if ($fields) {
    if ($table === 'bands') {
      $res = getBandsByGenre($term);
    } else {
      $res = getVenuesByGenre($term);
    }
  } else {
    $res = search($term, $table);
  }
?>
<div class='row'>
  <div class='twelve gray'>
    <h1>Search <?php echo $table . " for '" . $term . "'"; ?></h1>
    <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='post'>
      <div class='input-field'>
        <div class='radio-group'>
          <input type='radio' name='table' value='bands' required/>
          <p>Bands</p>
        </div>
        <div class='radio-group'>
          <input type='radio' name='table' value='venues' required />
          <p>Venues</p>
        </div>
        <div class='radio-group'>
          <input type='checkbox' name='genre' value='true' />
          <p>Search By Genre Only</p>
        </div>
      </div>
      <div class='input-field'>
        <input type='text' name='term' placeholder='Search...' required/>
      </div>
      <input type='submit' name='sumbit' value='submit' />
    </form>
  </div>
</div>
<div class='row'>
  <div id='item-group'>
    <div class='header'>
      <h3>Results</h3>
      <div class='btn-group'>
        <button id='view-grid'><i class='material-icons'>grid_on</i></button>
        <button id='view-list'><i class='material-icons'>view_list</i></button>
      </div>
    </div>
    <div id='theList' class='grid'>
      <?php
      if (isset($_POST['term'])) {
  while ($row = $res->fetch_assoc()) {
    ?>
      <div class='gray item'>
        <?php if ($table == 'bands') {?>
          <h2><a href='band.php?id=<?php echo htmlspecialchars_decode($row['id']); ?>' title='View Band'><?php echo htmlspecialchars_decode($row['name']); ?></a></h2>
        <?php } else {
          ?>
          <h2><a href='venue.php?id=<?php echo htmlspecialchars_decode($row['id']); ?>' title='View Venue'><?php echo htmlspecialchars_decode($row['name']); ?></a></h2>
          <?php
        }
        ?>
        <p><small>
          <?php echo $row['location']; ?> |
          <a href='mailto:<?php echo htmlspecialchars_decode($row["email"]); ?>'><?php echo htmlspecialchars_decode($row["email"]); ?></a> |
          <?php if ($row["music_link"] != null || $row["music_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["music_link"]); ?>' target='_blank'>Music</a>  <?php echo "| "; } ?>
          <?php if ($row["facebook_link"] != null || $row["facebook_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["facebook_link"]); ?>' target='_blank'>Facebook</a>  <?php echo "| ";} ?>
          <?php if ($row["website_link"] != null || $row["website_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["website_link"]); ?>' target='_blank'>Website</a><?php } ?>
        </small></p>
        <?php if ($table == 'bands') {?>
          <a href='band.php?id=<?php echo htmlspecialchars_decode($row['id']); ?>' title='View Band' class='btn'>Read More<i class='material-icons'>arrow_right</i></a>
        <?php } else {
          ?>
          <a href='venue.php?id=<?php echo htmlspecialchars_decode($row['id']); ?>' title='View Venue' class='btn'>Read More<i class='material-icons'>arrow_right</i></a>
          <?php
        }
        ?>
      </div>
    <?php
  }
  if (!is_object($res)) {
    ?>
    <div class='gray item'>
      <h3>We're sorry, there was an error getting your result. Please try again</h3>
      <p>
        Keep seeing this? Email <a href='mailto:mods@diymke.org'>mods@diymke.org</a>
        about what happened.
      </p>
    </div>
    <?php
  }
} else {
    ?>
    <div class='gray item'>
      <h3>No Search Term Entered</h3>
    </div>
    <?php
  }?>
    </div>
  </main>
<?php
  include 'inc/footer.php';
  ?>
