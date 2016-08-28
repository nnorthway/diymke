<?php
include 'functions.php';

if (isset($_POST['submit'])) {
  $file = '';
  $url = '';
  $valid_file = false;
  $fileURL = '';
  //verify file type & size
  if ($_FILES['event_image']['name']) {
    if (!$_FILES['event_image']['error']) {
      $new_file_name = strtolower($_FILES['event_image']['name']);
      $fileURL = '../uploaded/' . basename($new_file_name);
      if ($_FILES['event_image']['size'] > (1024000)) {
        header('Location: ../submit.php#file_size_limit');
        exit;
      }
      $type = $_FILES['event_image']['type'];
      if (
        $type != 'image/gif' &&
        $type != 'image/jpeg' &&
        $type != 'image/jpg' &&
        $type != 'image/pjpeg' &&
        $type != 'image/png'
      ) {
        header('Location: ../submit.php#file_type');
        exit;
      }
      move_uploaded_file($_FILES['event_image']['tmp_name'], $fileURL);
      $file = "uploaded/" . $new_file_name;
    } else {
      //header('Location: ../submit.php#error');
      echo $_FILES['event_image']['error'];
      exit;
    }
  }

  $arr = array(
    'id' => $_POST['id'],
    'name' => htmlspecialchars($_POST['event_name']),
    'venue_name' => htmlspecialchars($_POST['venue_name']),
    'venue_address' => strlen($_POST['venue_address']) > 0 ? htmlspecialchars($_POST['venue_address']) : null,
    'venue_link' => strlen($_POST['venue_link']) > 0 ? htmlspecialchars($_POST['venue_link']) : null,
    'fb_event' => strlen($_POST['fb_event']) > 0 ? htmlspecialchars($_POST['fb_event']) : null,
    'other_event' => strlen($_POST['other_event']) > 0 ? htmlspecialchars($_POST['other_event']) : null,
    'image' => strlen($file) > 0 ? $file : $_POST['event_default_image'],
    'cover_charge' => strlen($_POST['cover_charge']) > 0 ? htmlspecialchars($_POST['cover_charge']) : null,
    'date' => htmlspecialchars($_POST['date']),
    'start_time' => htmlspecialchars($_POST['start_time']),
    'event_type' => htmlspecialchars($_POST['event_type']),
    'age_restriction' => htmlspecialchars($_POST['age_restriction']),
    'description' => strlen($_POST['description']) > 0 ? htmlspecialchars($_POST['description']) : null,
    'host_email' => htmlspecialchars($_POST['host_email']),
    'is_verified' => false,
    'is_moderated' => false
  );

  //add to the database
  $res = updateEvent($arr);

  if ($res) {
    header('Location: events.php#success');
    exit;
  } else {
    header('Location: events.php#error');
    exit;
  }
} else {
  include 'inc/head.php';
include 'inc/header.php';
  ?>
  <title>Edit Event</title>
</head>
<body>
<main>
<?php
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
    <div class='twelve gray '>
      <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' enctype='multipart/form-data'>
        <?php
          if ($row['image'] != null && $row['image'] != "") {
            echo "<img src='../" . $row['image'] . "' class='event-image' />";
          }

        ?>
        <input type='hidden' name='event_default_image' value='<?php echo $row['event_image']; ?>' />
        <input type='hidden' name='id' value='<?php echo $row['id']; ?>' />
        <div class='input-field'>
          <label for='event_image'>Update Event Image</label>
          <input type='file' accept='image/*' name='event_image' />
        </div>
        <div class='input-field'>
          <label for='event_name'>Event Name</label>
          <input type='text' name='event_name' value='<?php echo $row['name']; ?>' />
        </div>
        <div class='input-field'>
          <label for='date'>Event Date</label>
          <input type='date' name='date' value='<?php echo date("Y-m-d", strtotime($row['date'])); ?>' />
        </div>
        <div class='input-field'>
          <label for='start_time'>Start Time</label>
          <input type='time' name='start_time' value='<?php echo $row['start_time']; ?>' />
        </div>
        <div class='input-field'>
          <label for='description'>Description</label>
          <textarea name='description'>
            <?php
              if ($row['description'] != null && $row['description'] != '') {
                echo $row['description'];
              }
            ?>
          </textarea>
        </div>
        <div class='input-field'>
          <label for='venue_link'>Venue Link On DIY:MKE</label>
          <input type='text' name='venue_link' value='<?php if ($row['venue_link'] != null && $row['venue_link'] != "") { echo $row['venue_link']; } ?>' />
        </div>
        <div class='input-field'>
          <label for='venue_name'>Venue Name</label>
          <input type='text' name='venue_name' value='<?php if ($row['venue_name'] != null && $row['venue_name'] != "") { echo $row['venue_name']; } ?>' />
        </div>
        <div class='input-field'>
          <label for='venue_address'>Venue Address</label>
          <input type='text' name='venue_address' value='<?php if ($row['venue_address'] != null && $row['venue_address'] != "") { echo $row['venue_address']; } ?>' />
        </div>
        <div class='input-field'>
          <label for='fb_event'>Facebook Event Link</label>
          <input type='text' name='fb_event' value='<?php if ($row["fb_event"] != null && $row["fb_event"] != "") { echo $row['fb_event'];} ?>' />
        </div>
        <div class='input-field'>
          <label for='other_event'>Other Event Link</label>
          <input type='text' name='other_event' value='<?php if ($row["other_event"] != null && $row["other_event"] != "") { echo $row['other_event']; } ?>' />
        </div>
        <div class='input-field'>
          <label for='cover_charge'>Cover Charge</label>
          <input type='number' name='cover_charge' min='0' max='1000' step='0.5' value='<?php if ($row['cover_charge'] != null && $row['cover_charge'] != "") { echo $row['cover_charge']; }?>' />
        </div>
        <div class='input-field'>
          <label for='event_type'>Event Type (required)</label>
          <select name='event_type' required>
            <option value='art_show' <?php if ($row['event_type'] == 'art_show') {echo "selected"; } ?>>Art Show</option>
            <option value='concert' <?php if ($row['event_type'] == 'concert') {echo "selected"; } ?>>Concert/Live Music</option>
            <option value='meeting' <?php if ($row['event_type'] == 'meeting') {echo "selected"; } ?>>Meeting (Org, Committee, etc)</option>
            <option value='potluck' <?php if ($row['event_type'] == 'potluck') {echo "selected"; } ?>>Potluck</option>
            <option value='benefit' <?php if ($row['event_type'] == 'benefit') {echo "selected"; } ?>>Fundraiser/Benefit Show</option>
            <option value='fest' <?php if ($row['event_type'] == 'fest') {echo "selected"; } ?>>Festival</option>
            <option value='party' <?php if ($row['event_type'] == 'party') {echo "selected"; } ?>>Dance/Party</option>
            <option value='activism' <?php if ($row['event_type'] == 'activism') {echo "selected"; } ?>>Protest/Demonstration/Activism</option>
            <option value='workshop' <?php if ($row['event_type'] == 'workshop') {echo "selected"; } ?>>Workshop/Skillshare</option>
          </select>
        </div>
        <div class='input-field'>
          <label for='age_restriction'>Age Restriction (required)</label>
          <select name='age_restriction' required>
            <option value='All Ages' <?php if ($row['age_restriction'] == 'all_ages') { echo "selected"; } ?>>All Ages</option>
            <option value='18+' <?php if ($row['age_restriction'] == '18_up') { echo "selected"; } ?>>18+</option>
            <option value='21+' <?php if ($row['age_restriction'] == '21_up') { echo "selected"; } ?>>21+</option>
          </select>
        </div>
        <div class='input-field'>
          <label for='host_email'>Host Email</label>
          <input type='email' name='host_email' value='<?php echo $row['host_email']; ?>' />
        </div>
        <button class='btn' name='submit' value='submit'>Update</button>
    </form>
    </div>
  </div>
</main>
<?php }} ?>
<?php include 'inc/footer.php'; ?>
