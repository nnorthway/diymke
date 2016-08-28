<?php include 'inc/header.php'; ?>
<?php
  include 'functions.php';
  $row = getEvent($_GET['id']);

  if (!$row) {
    ?>
<div class='row'>
  <div class='error-msg'>
    <h1>There was an error fetching data :(</h1>
    <p>
    Our team is working on this. We're sorry.
    </p>
  </div>
</div>
</main>
<?php } else {?>
  <div class='row'>
    <div class='twelve gray event'>
      <div class='event-head'>
        <?php
          if ($row['image'] != null && $row['image'] != "") {
            echo "<img src='" . $row['image'] . "' class='event-image' />";
          }
        ?>
        <p class=''>
          <?php echo date('D, F d Y', strtotime($row['date'])); ?> at <?php echo date("h:i A", strtotime($row['start_time'])); ?>
        </p>
        <h1><?php echo htmlspecialchars_decode($row['name']); ?></h1>
        <br />
      </div>
      <small>
        <?php
          if ($row['venue_link'] != null && $row['venue_link'] != "") {echo "At <a href='" . htmlspecialchars_decode($row['venue_link']) . "'>";}
          if ($row['venue_name'] != null && $row['venue_name'] != "") {echo htmlspecialchars_decode($row['venue_name']); }
          if ($row['venue_link'] != null && $row['venue_link'] != "") {echo "</a> | "; }
          if ($row['venue_address'] != null && $row['venue_address'] != "") { echo $row['venue_address'] . " | "; }?>
        <?php
          if ($row["fb_event"] != null && $row["fb_event"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["fb_event"]); ?>' target='_blank'>Facebook Event</a>  <?php echo "| ";}
          if ($row["other_event"] != null && $row["other_event"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["other_event"]); ?>' target='_blank'>Other Event</a>  <?php echo "| ";}
          if ($row['cover_charge'] != null && $row['cover_charge'] != "" && $row['cover_charge'] != '0') {echo "Cover: $" . htmlspecialchars_decode($row['cover_charge']);} else {echo "Cover: Free";}
        ?>
      </small>
      <p>
        Event Type: <?php echo htmlspecialchars_decode($row['event_type']); ?><br />
        Age Restriction: <?php echo htmlspecialchars_decode($row['age_restriction']); ?><br />
      <p class='lead'>
        <?php echo htmlspecialchars_decode($row['description']); ?>
      </p>
    </div>
  </div>
</main>
<?php } ?>
<?php include 'inc/footer.php'; ?>
