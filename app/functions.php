<?php
function conn() {
  //return new mysqli("localhost", "diymkeor_diymke", "utrhf5cs!", "diymkeor_diymke");
  return new mysqli('localhost','root','root','diymke');
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
  $to = "nate@natenorthway.com";
  $from = "no-reply@diymke.org";
  $headers = 'From: no-reply@diymke.org' . "\r\n" .
    'Reply-To: no-reply@diymke.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);
}
?>
