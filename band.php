<?php include 'inc/header.php'; ?>
<?php
  include 'functions.php';
  $result = getBand($_GET['id']);

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
      <div class='row'>
        <div class='eight shift-two gray'>
          <h2><?php echo htmlspecialchars_decode($row['name']); ?></h2>
          <small>
            <?php if ($row['location'] != null && $row['location'] != "") { echo $row['location'] . " | "; }?>
            <a href='mailto:<?php echo htmlspecialchars_decode($row["email"]); ?>'><?php echo htmlspecialchars_decode($row["email"]); ?></a> |
            <?php if ($row["music_link"] != null && $row["music_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["music_link"]); ?>' target='_blank'>Music</a>  <?php echo "| ";} ?>
            <?php if ($row["facebook_link"] != null && $row["facebook_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["facebook_link"]); ?>' target='_blank'>Facebook</a>  <?php echo "| ";} ?>
            <?php if ($row["website_link"] != null && $row["website_link"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["website_link"]); ?>' target='_blank'>Website</a><?php } ?>
          </small>
          <p class='lead'>
            <?php echo htmlspecialchars_decode($row['description']); ?>
          </p>
          <ul>
            <li>Genres: <?php echo htmlspecialchars_decode($row['genres']); ?></li>
            <li>Band Since: <?php echo htmlspecialchars_decode($row['year_established']); ?></li>
            <li>Last Updated: <?php echo date('D, F d Y', htmlspecialchars_decode($row['last_update'])); ?></li>
          </ul>
        </div>
      </div>
    <?php
    }
  }
?>
</main>
<?php include 'inc/footer.php'; ?>
