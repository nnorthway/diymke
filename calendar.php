
<?php
include 'functions.php';
include 'inc/header.php';
?>
  <div id='item-group'>
    <div class='header'>
      <h3>Calendar</h3>
      <div class='btn-group'>
        <button id='view-grid'><i class='material-icons'>grid_on</i></button>
        <button id='view-list'><i class='material-icons'>view_list</i></button>
      </div>
    </div>
  <div class='row'>
    <div class='six shift-three error-msg red' id='error'>
      <h1>Oops.</h1>
      <p>Something went wrong. Try again</p>
    </div>
  </div>
  <div id='theList' class='grid'>
      <?php
      $res = getEvents();
      while ($row = $res->fetch_assoc()) {
        if ($row['date'] > date("Y-m-d")) {
        ?>
          <div class='item gray event'>
            <div class='event-head'>
              <p class='text-right'>
                <?php echo date('D, F d Y', strtotime($row['date'])); ?> <br /><?php echo date("h:i A", strtotime($row['start_time'])); ?>
              </p>
              <h1><a href='event.php?id="<?php echo $row['id']; ?>"'><?php echo htmlspecialchars_decode($row['name']); ?></a></h1>
              <?php
                if ($row['image'] != null && $row['image'] != "") {
                  echo "<img src='" . $row['image'] . "' class='event-image' />";
                }
              ?>
              <br />
            </div>
            <small>
              <?php
                if ($row['venue_link'] != null && $row['venue_link'] != "") {echo "<a href='" . htmlspecialchars_decode($row['venue_link']) . "'>";}
                if ($row['venue_name'] != null && $row['venue_name'] != "") {echo htmlspecialchars_decode($row['venue_name']) . " | "; }
                if ($row['venue_link'] != null && $row['venue_link'] != "") {echo "</a>"; }
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
            <a href='event.php?id="<?php echo $row['id']; ?>"' class='btn'>View Event Page<i class='material-icons'>keyboard_arrow_right</i></a>
          </div>
        <?php
      }}
      ?>
    </div>
  </div>
</main>
<?php include 'inc/footer.php'; ?>
