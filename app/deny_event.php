<?php
include 'functions.php';
$id = $_GET['id'];
if (isset($_GET['submit'])) {
  $id = $_GET['id'];
  $message = $_GET['message'];
  if (denyEvent($id, $message)) {
    header('Location: events.php#denied');
    exit;
  } else {
    header('Location: events.php#error');
    exit;
  }
} else {
  include 'inc/head.php';
  ?>
<body>
  <?php include 'inc/header.php'; ?>
  <main>
    <div class='row'>
      <div class='twelve gray'>
        <p class='lead offset'>
          Deny Event
        </p>
      </div>
    </div>
    <div class='row'>
      <div class='eight shift-two gray'>
        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='get'>
          <div class='input-field'>
            <label for='message'>Why was this event submission denied?</label>
            <textarea name='message' placeholder='Be descriptive and reasonable.'></textarea>
          </div>
          <input type='hidden' name='id' value='<?php echo $id; ?>' />
          <button name='submit' value='submit' class='btn'>Deny This Event</button>
        </form>
      </div>
  </main>
  <?php
  include 'inc/footer.php';
}

?>
