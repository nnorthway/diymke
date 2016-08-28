<?php
function conn() {
  return new mysqli("localhost", "diymkeor_diymke", "utrhf5cs!", "diymkeor_diymke");
  //return new mysqli('localhost','root','root','diymke');
}

function isLocalInstall() {
  return false;
}

function checkConn($conn) {
  if ($conn->connect_errno) {
    $error = "MySQL Connection Error: " . $conn->connect_errno . ": " . $conn->connect_error;
    sendErrorReport($error);
    return false;
  } else {
    return true;
  }
}

function checkRes($res, $conn, $func) {
  if (!$res) {
    $error = "Query Error: " . $conn->sqlstate . ": " . $conn->error;
    $error .= "Function name: " . $func;
    sendErrorReport($error);
    return false;
  } else {
    return true;
  }
}

function logIn($user, $pass) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `users`
WHERE `email` = '$user'
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'logIn')) {
    return false;
  }
  $match = false;
  $id = 0;
  while ($row = $res->fetch_assoc()) {
    $hash = substr($row['pass'], 0, 60);
    $match = password_verify($pass, $hash);
    $id = $row['id'];
  }
  if (!$match) {
    return false;
    exit;
  }
  $newQuery = "UPDATE `users` SET `login_ip` = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE `id` = " . $id . "";
  $newRes = $conn->query($newQuery);
  if (!checkRes($newRes, $conn, 'logIn - IP Log')) {
    return false;
  }
  return true;
}

function logOut() {
  session_start();
  session_destroy();
  return true;
}

function isLoggedIn() {
  session_start();
  $case = isset($_SESSION['name']);
  if ($case) {
    return true;
  } else {
    return false;
  }
}

function getBands() {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `bands`
ORDER BY `name`
ASC
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getBands')) {
    return false;
  }
  ?>
  <table>
    <thead>
      <th>Name</th>
      <th>View</th>
      <th>Edit</th>
      <th>Delete</th>
    </thead>
    <tbody>
      <?php
  while ($row = $res->fetch_assoc()) {
    ?>
    <tr>
      <td><?php echo $row['name']; ?></td>
      <td><a href='../band.php?id=<?php echo $row['id']; ?>' title='View Band'>View Band</a></td>
      <td><a href='edit-band.php?id=<?php echo $row['id']; ?>' title='Edit Band'>Edit Band</a></td>
      <td><a href='delete-band.php?id=<?php echo $row['id']; ?>' title='Delete Band'>Delete Band</a></td>
    </tr>
    <?php
  }?>
  </tbody>
  <tfoot>
    <th>Name</th>
    <th>View</th>
    <th>Edit</th>
    <th>Delete</th>
  </tfoot>
</table>
<?php
}

function getVenues() {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `venues`
ORDER BY `name`
DESC
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getVenues')) {
    return false;
  }
  ?>
  <table>
    <thead>
      <th>Name</th>
      <th>View</th>
      <th>Edit</th>
      <th>Delete</th>
    </thead>
    <tbody>
      <?php
  while ($row = $res->fetch_assoc()) {
    ?>
    <tr>
      <td><?php echo $row['name']; ?></td>
      <td><a href='../venue.php?id=<?php echo $row['id']; ?>' title='View Venue'>View Venue</a></td>
      <td><a href='edit-venue.php?id=<?php echo $row['id']; ?>' title='Edit Venue'>Edit Venue</a></td>
      <td><a href='delete-venue.php?id=<?php echo $row['id']; ?>' title='Delete Venue'>Delete Venue</a></td>
    </tr>
    <?php
  }?>
  </tbody>
  <tfoot>
    <th>Name</th>
    <th>View</th>
    <th>Edit</th>
    <th>Delete</th>
  </tfoot>
</table>
<?php
}

function getBandPost($postID) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `bands`
WHERE `id` = $postID
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getBandPost')) {
    return false;
  }
  $row = $res->fetch_assoc();
  return $row;
}

function getVenuePost($id) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `venues`
WHERE `id` = $id
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getVenuePost')) {
    return false;
  }
  $row = $res->fetch_assoc();
  return $row;
}


function updateBand($vals) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = "UPDATE `bands`
SET `name` = '" . $conn->real_escape_string($vals['name']) . "',
`description` = '" . $conn->real_escape_string($vals['description']) . "',
`location` = '" . $conn->real_escape_string($vals['location']) . "',
`email` = '" . $conn->real_escape_string($vals['email']) . "',
`music_link` = '" . $conn->real_escape_string($vals['music_link']) . "',
`website_link` = '" . $conn->real_escape_string($vals['website_link']) . "',
`facebook_link` = '" . $conn->real_escape_string($vals['facebook_link']) . "',
`year_established` = '" . $conn->real_escape_string($vals['year_established']) . "',
`genres` = '" . $conn->real_escape_string($vals['genres']) . "',
`last_update` = '" . time() . "'
WHERE `id` = '" . $vals['id'] . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'updateBand')) {
    return false;
  }
  return true;
}

function updateVenue($vals) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  foreach ($vals as $key => $val) {
    $val = $conn->real_escape_string($val);
  }
$query = "UPDATE `venues`
SET
  `name` = '" . $conn->real_escape_string($vals['name']) . "',
  `location` = '" . $conn->real_escape_string($vals['location']) . "',
  `email` = '" . $conn->real_escape_string($vals['email']) . "',
  `website_link` = '" . $conn->real_escape_string($vals['website_link']) . "',
  `description` = '" . $conn->real_escape_string($vals['description']) . "',
  `facebook_link` = '" . $conn->real_escape_string($vals['facebook_link']) . "',
  `year_established` = '" . $conn->real_escape_string($vals['year_established']) . "',
  `genres` = '" . $conn->real_escape_string($vals['genres']) . "',
  `last_update` = '" . time() . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'updateVenue')) {
    return false;
  }
  return true;
}

function deleteBand($id) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  $query = "DELETE FROM `bands` WHERE `id` = '" . $id . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'deleteBand')) {
    return false;
  }
  return true;
}

function deleteVenue($id) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  $query = "DELETE FROM `venues` WHERE `id` = '" . $id . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'deleteVenue')) {
    return false;
  }
  return true;
}

function getUnmoderatedEvents() {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `events`
WHERE `is_moderated` = FALSE
ORDER BY `id`
DESC
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getUnapprovedEvents')) {
    return false;
  }
  return $res;
}

function getUnapprovedEvents() {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `events`
WHERE `is_verified` = FALSE
ORDER BY `id`
DESC
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getUnapprovedEvents')) {
    return false;
  }
  return $res;
}

function getEvent($id) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `events`
WHERE `id` = $id
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getEvent')) {
    return false;
  }
  return $res->fetch_assoc();
}

function getEvents() {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `events`
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getEvents')) {
    return false;
  }
  return $res;
}

function approveEvent($id) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = "UPDATE `events`
SET
  `is_verified` = 1,
  `is_moderated` = 1
WHERE `id` = '" . $id . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'approveEvent')) {
    return false;
  }
  $row = getEvent($id);
  $sendTo = $row['host_email'];
  $from = "no-reply@diymke.org";
  $subject = "DIY:MKE: Your Event Was approved";
  $message = "
<html>
  <head>
    <title>DIY:MKE: Your event was approved</title>
  </head>
  <body>
    <p>
      Hi, " . $row['host_email'] . ", we're writing you to inform you
      that your event, " . $row['name'] . ", has been approved and can
      be found at <a href='http://diymke.org/event.php?id" . $row['id'] . "'>this link</a>.
    </p>
    <hr />
    <small>
      This email was sent automatically. Please do not respond directly to this email. We will no longer contact you without
      prior consent. We will not advertise to you or sell or share your email address to
      other businesses.
    </small>
  </body>
</html>
  ";
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; chaset=iso-8859-1' . "\r\n";
  $headers .= 'To: Host <' . $sendTo . '>' . "\r\n";
  $headers .= 'From: <no-reply@diymke.org>' . "\r\n";
  mail($sendTo, $subject, $message, $headers);
  return true;
}

function denyEvent($id, $denyMessage) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = "UPDATE `events`
SET `is_verified` = 0,
    `is_moderated` = 1
WHERE `id` = '" . $id . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'denyEvent')) {
    return false;
  }
  $row = getEvent($id);
  $sendTo = $row['host_email'];
  $from = "no-reply@diymke.org";
  $subject = "DIY:MKE: Your Event Was Denied";
  $message = "
  <html>
  <head>
    <title>DIY:MKE: Your Event Was Denied</title>
  </head>
  <body>
    <p>
      Hi, " . $row['host_email'] . ", we're writing you to inform you
      that your event, " . $row['name'] . ", has been denied for the following
      reason: <br />" . $denyMessage . "<br />
      If you would like to challenge this or offer revised information, you can
      do so at http://diymke.org/contact. Please provide the following information
      at the top of your message and select the subject 'I'd like to  my event':<br />
      Event ID: " . $id . "<br />
      Reason For Denial: " . $denyMessage . "
    </p>
    <hr />
    <small>
      This email was sent automatically. Please do not respond directly to this email. We will no longer contact you without
      prior consent. We will not advertise to you or sell or share your email address to
      other businesses.
    </small>
  </body>
  </html>
  ";
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; chaset=iso-8859-1' . "\r\n";
  $headers .= 'To: Host <' . $sendTo . '>' . "\r\n";
  $headers .= 'From: <no-reply@diymke.org>' . "\r\n";
  mail($sendTo, $subject, $message, $headers);
  return true;
}

function deleteEvent($id) {
  $stmt = "DELETE FROM `events` WHERE `id` = $id";
  $conn = conn();
  $res = $conn->query($stmt);
  if (!$res) {
    unset($res);
    return false;
  }
  return true;
}

function clearEvents() {
  $res = getEvents();
  while ($row = $res->fetch_assoc()) {
    if ($row['date'] < date('Y-m-d')) {
      if (!deleteEvent($row['id'])) {
        return false;
      }
    }
  }
  return true;
}

function updateEvent($arr) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  $eventType = str_replace('_', ' ', $arr['event_type']);
  $query = "UPDATE `events`
  SET
    `name` = '" . $conn->real_escape_string($arr['name']) . "',
    `venue_name` = '" . $conn->real_escape_string($arr['venue_name']) . "',
    `venue_address` = '" . $conn->real_escape_string($arr['venue_address']) . "',
    `venue_link` = '" . $conn->real_escape_string($arr['venue_link']) . "',
    `fb_event` = '" . $conn->real_escape_string($arr['fb_event']) . "',
    `other_event` = '" . $conn->real_escape_string($arr['other_event']) . "',
    `image` = '" . $conn->real_escape_string($arr['image']) . "',
    `cover_charge` = '" . $conn->real_escape_string($arr['cover_charge']) . "',
    `date` = '" . $conn->real_escape_string($arr['date']) . "',
    `start_time` = '" . $conn->real_escape_string($arr['start_time']) . "',
    `event_type` = '" . $conn->real_escape_string($eventType) . "',
    `age_restriction` = '" . $conn->real_escape_string($arr['age_restriction']) . "',
    `description` = '" . $conn->real_escape_string($arr['description']) . "',
    `host_email` = '" . $conn->real_escape_string($arr['host_email']) . "'
  WHERE `id` = " . $arr['id'];
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'updateEvent')) {
    return false;
  }
  return true;
}

function getUsers() {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `users`
ORDER BY `id`
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getUsers')) {
    return false;
  }
  while ($row = $res->fetch_assoc()) {
    ?>
    <tr>
      <td><?php echo $row['f_name'] . " " . $row['l_name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><a href='edit-user.php?id=<?php echo $row['id']; ?>' title='Edit User'>Edit User</a> <a href='delete-user.php?id=<?php echo $row['id']; ?>' title='Delete User'>Delete User</a></td>
    </tr>
    <?php
  }
}

function getUser($id) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `users`
WHERE `id` = '$id'
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getUser')) {
    return false;
  }
  $row = $res->fetch_assoc();
  return $row;
}

function getUserByEmail($email) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
$query = <<<SQL
SELECT *
FROM `users`
WHERE `email` = '$email'
SQL;
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'getUserByEmail')) {
    return false;
  }
  $row = $res->fetch_assoc();
  return $row;
}

function updateUser($vars) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  $query = "UPDATE `users`
  SET
  `f_name` = '" . $conn->real_escape_string($vars['f_name']) . "',
  `l_name` = '" . $conn->real_escape_string($vars['l_name']) . "',
  `email` = '" . $conn->real_escape_string($vars['email']) . "',
  `pass` = '" . $conn->real_escape_string($vars['pass']) . "'
  WHERE `id` = '" . $conn->real_escape_string($vars['id']) . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'updateUser')) {
    return false;
  }
  return true;
}

function updatePassword($id, $newPassword) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
  $query = "UPDATE `users` SET `pass` = '" . $newPasswordHash . "' WHERE `id` = '" . $id . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'updatePassword')) {
    return false;
  }
  return true;
}

function createUser($vars) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  $hash = password_hash($vars['password'], PASSWORD_DEFAULT);
  $query = "INSERT INTO `users` (`f_name`, `l_name`, `email`, `pass`)
  VALUES (
  '" . $conn->real_escape_string($vars['f_name']) . "',
  '" . $conn->real_escape_string($vars['l_name']) . "',
  '" . $conn->real_escape_string($vars['email']) . "', '"
   .  $hash . "')";
  $res = $conn->query($query);
  if (!$res) {
    return false;
  }
  return true;
}

function deleteUser($id) {
  $conn = conn();
  if (!checkConn($conn)) {
    return false;
  }
  $query = "DELETE FROM `users` WHERE `id` = '" . $id . "'";
  $res = $conn->query($query);
  if (!checkRes($res, $conn, 'deleteUser')) {
    return false;
  }
  return true;
}

function sendErrorReport($error) {
  $subject = "DIYMKE: Error Report";
  $message = "DIYMKE: Error Report \r\n" . $error;
  $to = "mods@diymke.org";
  $from = "no-reply@diymke.org";
  $headers = 'From: no-reply@diymke.org' . "\r\n" .
    'Reply-To: no-reply@diymke.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);
}
?>
