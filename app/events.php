<?php
include 'functions.php';
if (!isLoggedIn()) {
  header('Location: login.php');
  exit;
}
include 'inc/head.php';
?>
<title>Events</title>
</head>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          Events Queued for Moderation
        </p>
      </section>
    </div>
    <div class='row'>
      <div class='six shift-three error-msg green' id='approved'>
        <h1>Event Approved</h1>
      </div>
      <div class='six shift-three error-msg green' id='denied'>
        <h1>Event Denied</h1>
      </div>
      <div class='six shift-three error-msg green' id='success'>
        <h1>Event Updated</h1>
      </div>
      <div class='six shift-three error-msg red' id='error'>
        <h1>Oops.</h1>
        <p>Something went wrong. Try again</p>
      </div>
    </div>
    <div class='row'>
      <div class='eight shift-two'>
        <?php
        $res = getUnmoderatedEvents();
        while ($row = $res->fetch_assoc()) {
          if ($row['date'] > date("Y-m-d")) {
          ?>
          <div class='row'>
            <div class='twelve gray'>
              <h2><?php echo htmlspecialchars_decode($row['name']); ?></h2>
              <small>
                <?php
                  if ($row['venue_link'] != null && $row['venue_link'] != "") {echo "<a href='" . htmlspecialchars_decode($row['venue_link']) . "'>";}
                  if ($row['venue_name'] != null && $row['venue_name'] != "") {echo htmlspecialchars_decode($row['venue_name']) . " | "; }
                  if ($row['venue_link'] != null && $row['venue_link'] != "") {echo "</a>"; }
                  if ($row['venue_address'] != null && $row['venue_address'] != "") { echo $row['venue_address'] . " | "; }?>
                <a href='mailto:<?php echo htmlspecialchars_decode($row["host_email"]); ?>'><?php echo htmlspecialchars_decode($row["host_email"]); ?></a> |
                <?php
                  if ($row["fb_event"] != null && $row["fb_event"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["fb_event"]); ?>' target='_blank'>Facebook Event</a>  <?php echo "| ";}
                  if ($row["other_event"] != null && $row["other_event"] != "") {?><a href='<?php echo htmlspecialchars_decode($row["other_event"]); ?>' target='_blank'>Other Event</a>  <?php echo "| ";}
                  if ($row['cover_charge'] != null && $row['cover_charge'] != "" && $row['cover_charge'] != '0') {echo "Cover: $" . htmlspecialchars_decode($row['cover_charge']);} else {echo "Cover: Free";}
                ?>
              </small>
              <p>
                Date: <?php echo date('D, F d Y', strtotime($row['date'])); ?> at <?php echo date("h:i A", strtotime($row['start_time'])); ?><br />
                Event Type: <?php echo htmlspecialchars_decode($row['event_type']); ?><br />
                Age Restriction: <?php echo htmlspecialchars_decode($row['age_restriction']); ?><br />
              <p class='lead'>
                <?php echo htmlspecialchars_decode($row['description']); ?>
              </p>
              <a href='approve_event.php?id=<?php echo $row["id"]; ?>' class='btn'>
                Approve Event
              </a>
              <a href='deny_event.php?id=<?php echo $row["id"]; ?>' class='btn'>
                Deny Event
              </a>
            </div>
          </div>
          <?php
        }}
        ?>
      </div>
    </div>
    <div class='row'>
      <section class='twelve gray'>
        <p class='lead offset'>
          All Events
        </p>
      </section>
    </div>
    <div class='row'>
      <table>
        <thead>
          <th>Name</th>
          <th>Approved</th>
          <th>Edit</th>
          <th>Delete</th>
        </thead>
        <tbody>
          <?php
          $res = getEvents();
          while ($row = $res->fetch_assoc()) {
            ?>
            <tr>
              <td><a href='../event.php?id=<?php echo $row['id']; ?>'><?php echo htmlspecialchars_decode($row['name']); ?></a></td>
              <td>
                <?php
                if ($row['is_verified'] && $row['is_moderated']) {
                  echo "Approved";
                } else if (!$row['is_moderated']){
                  echo "Needs Moderation";
                } else {
                  echo "Denied";
                }
                ?>
              </td>
              <td><a href='edit-event.php?id=<?php echo $row['id']; ?>'>Edit</a></td>
              <td><a href='delete-event.php?id=<?php echo $row['id']; ?>'>Delete</a></td>
            </tr>
            <?php
          }
          ?>
        </tbody>
        <tfoot>
          <th>Name</th>
          <th>Approved</th>
          <th>Edit</th>
          <th>Delete</th>
        </tfoot>
      </table>
    </div>
  </main>
  <?php include 'inc/footer.php'; ?>
</body>
</html>
