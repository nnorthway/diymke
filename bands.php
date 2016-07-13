<?php include 'inc/header.php'; ?>
<div id='item-group'>
  <div class='header'>
    <h3>Bands</h3>
    <div class='btn-group'>
      <button id='view-grid'><i class='material-icons'>grid_on</i></button>
      <button id='view-list'><i class='material-icons'>view_list</i></button>
    </div>
  </div>
  <div id='theList' class='grid'>
<?php
  include 'functions.php';
  $result = getBands();

  if (!$result) {
    echo "
<div class='row'>
  <div class='error-msg'>
    <h1>There was an error fetching data :(</h1>
    <p>
    Our team is working on this. We're sorry.
    </p>
  </div>
</div>
    ";
  } else {
    while ($row = $result->fetch_assoc()) {
    ?>
        <div class='gray item'>
          <h2><a href='band.php?id=<?php echo htmlspecialchars_decode($row['id']); ?>' title='View Band'><?php echo htmlspecialchars_decode($row['name']); ?></a></h2>
          <p><small>
            <?php echo $row['location']; ?> |
            <a href='mailto:<?php echo htmlspecialchars_decode($row["email"]); ?>'><?php echo htmlspecialchars_decode($row["email"]); ?></a> |
            <?php if ($row["music_link"] != null || $row["music_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["music_link"]); ?>' target='_blank'>Music</a>  <?php echo "| "; } ?>
            <?php if ($row["facebook_link"] != null || $row["facebook_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["facebook_link"]); ?>' target='_blank'>Facebook</a>  <?php echo "| ";} ?>
            <?php if ($row["website_link"] != null || $row["website_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["website_link"]); ?>' target='_blank'>Website</a><?php } ?>
          </small></p>
          <a href='band.php?id=<?php echo htmlspecialchars_decode($row['id']); ?>' title='View Band' class='btn'>Read More<i class='material-icons'>arrow_right</i></a>
        </div>
    <?php

    }
  }
?>
</div>
</div>
</main>
<?php include 'inc/footer.php'; ?>
