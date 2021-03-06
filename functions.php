<?php

function conn() {
  return new mysqli("localhost", "diymkeor_diymke", "utrhf5cs!", "diymkeor_diymke");
  //return new mysqli("localhost", "root", "root", "diymke");
}

function isLocalInstall() {
  return false;
}

function dbQuery($q) {
  $conn = conn();
  if ($conn->connect_errno) {
    $error = "Failed to connect to MySQL: (Error " . $conn->connect_errno . ") " . $conn->connect_error;
    sendErrorReport($error, "dbQuery");
  }
  $res = $conn->query($q);
  if ($res) {
    return $res;
  } else {
    $error = "Failed to submit query: (Error " . $conn->sqlstate . ") " . $conn->error;
    sendErrorReport($error, "dbQuery");
    return false;
  }
}

function dbInsert($query) {
  $conn = conn();
  if ($conn->connect_errno) {
    $error = "Failed to connect to MySQL: (Error " . $conn->connect_errno . ") " . $conn->connect_error;
    sendErrorReport($error, "dbInsert");
    if ($conn->query($query)) {
      return true;
    } else {
      $error = "Failed to submit query: (Error: " . $conn->sqlstate . ") " . $conn->error;
      sendErrorReport($error, "dbInsert");
      return false;
    }
  }
}

function getBandGenres($bandID) {
  $query = "SELECT * FROM `band_genres` WHERE `bandID` = '" . $bandID . "'";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function getVenueGenres($venueID) {
    $query = "SELECT * FROM `venue_genres` WHERE `venueID` = '" . $venueID . "'";
    $res = dbQuery($query);
    if (!$res) {
      unset($res);
      return false;
    } else {
      return $res;
    }
}

function getBandsByGenre($genreName) {
    $query = "SELECT * FROM `band_genres` JOIN `bands` ON `band_genres`.`bandID` = `bands`.`id` WHERE `band_genres`.`genre` LIKE '%" . $genreName . "%'";
    $res = dbQuery($query);
    if (!$res) {
      unset($res);
      return false;
    } else {
      return $res;
    }
}

function getVenuesByGenre($genreName) {
  $query = "SELECT * FROM `venue_genres` JOIN `venues` ON `venue_genres`.`venueID` = `venues`.`id` WHERE `venue_genres`.`genre` LIKE '%" . $genreName . "%'";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function getBands() {
  $query = "SELECT * FROM `bands` ORDER BY `name` ASC";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function getBand($id) {
  $query = "SELECT * FROM `bands` WHERE `id` = '" . $id . "'";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function getVenues() {
  $query = "SELECT * FROM `venues` ORDER BY `name` ASC";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function getVenue($id) {
  $query = "SELECT * FROM `venues` WHERE `id` = '" . $id . "'";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function prependHTTP($string) {

  $pos = strpos($string, "http://");
  $pos2 = strpos($string, "https://");

  if ($pos === false && $pos2 === false && $string != null) {
    return "http://" . $string;
  } else {
    return $string;
  }
}

function newBand($data) {
  $conn = conn();

  foreach ($data as $key => $val) {
    if ($val == "") {
      $val = null;
    }
  }
  $theQuery = "INSERT INTO `bands`(
    `name`,
    `location`,
    `email`,
    `music_link`,
    `website_link`,
    `facebook_link`,
    `description`,
    `year_established`,
    `genres`,
    `last_update`
  ) VALUES (
    '" . $conn->real_escape_string($data['name']) . "',
    '" . $conn->real_escape_string($data['location']) . "',
    '" . $conn->real_escape_string($data['email']) . "',
    '" . $conn->real_escape_string(prependHTTP($data['music_link'])) . "',
    '" . $conn->real_escape_string(prependHTTP($data['website_link'])) . "',
    '" . $conn->real_escape_string(prependHTTP($data['facebook_link'])) . "',
    '" . $conn->real_escape_string($data['description']) . "',
    '" . $conn->real_escape_string($data['year_established']) . "',
    '" . $conn->real_escape_string($data['genres']) . "',
    '" . time() . "')";
  $status = dbQuery($theQuery);
  if (!$status) {
    return false;
  } else {
    $genres = array();
    $genres = explode(", ", $conn->real_escape_string($data['genres']));
    $getQuery = "SELECT * FROM `bands` ORDER BY `id` DESC LIMIT 1";
    $result = dbQuery($getQuery);
    $band = $result->fetch_row();
    $bandID = $band[0];
    foreach ($genres as $genre) {
      $insertQuery = "INSERT INTO `band_genres` (`bandID`, `genre`) VALUES ('" . $bandID . "', '" . $genre . "')";
      $insertResult = dbQuery($insertQuery);
      if (!$insertResult) {
        return $insertResult;
      }
    }
    return true;
  }
}

function newVenue($data) {
  $conn = conn();
  $theQuery = "INSERT INTO `venues`(
    `name`,
    `location`,
    `email`,
    `website_link`,
    `description`,
    `facebook_link`,
    `year_established`,
    `genres`,
    `last_update`
  ) VALUES (
    '" . $conn->real_escape_string($data['name']) . "',
    '" . $conn->real_escape_string($data['location']) . "',
    '" . $conn->real_escape_string($data['email']) . "',
    '" . $conn->real_escape_string(prependHTTP($data['website_link'])) . "',
    '" . $conn->real_escape_string($data['description']) . "',
    '" . $conn->real_escape_string(prependHTTP($data['facebook_link'])) . "',
    '" . $conn->real_escape_string($data['year_established']) . "',
    '" . $conn->real_escape_string($data['genres']) . "',
    '" . time() . "')";
  $status = dbQuery($theQuery);
  if ($status === FALSE) {
    return $status;
  } else {
    $genres = array();
    $genres = explode(", ", $conn->real_escape_string($data['genres']));
    $getQuery = "SELECT * FROM `venues` ORDER BY `id` DESC LIMIT 1";
    $result = dbQuery($getQuery);
    $venue = $result->fetch_row();
    $venueID = $venue[0];
    foreach ($genres as $genre) {
      $insertQuery = "INSERT INTO `venue_genres` (`venueID`, `genre`) VALUES ('" . $venueID . "', '" . $genre . "')";
      $insertResult = dbQuery($insertQuery);
      if (!$insertResult) {
        return $insertResult;
      }
    }
    return true;
  }
}

function addEvent($data) {
  $conn = conn();
  $theQuery = "INSERT INTO `events`(
    `name`,
    `venue_name`,
    `venue_address`,
    `venue_link`,
    `fb_event`,
    `other_event`,
    `image`,
    `cover_charge`,
    `date`,
    `start_time`,
    `event_type`,
    `age_restriction`,
    `description`,
    `host_email`,
    `is_verified`
  ) VALUES (
    '" . $conn->real_escape_string($data['name']) . "',
    '" . $conn->real_escape_string($data['venue_name']) . "',
    '" . $conn->real_escape_string($data['venue_address']) . "',
    '" . $conn->real_escape_string(prependHTTP($data['venue_link'])) . "',
    '" . $conn->real_escape_string(prependHTTP($data['fb_event'])) . "',
    '" . $conn->real_escape_string(prependHTTP($data['other_event'])) . "',
    '" . $conn->real_escape_string($data['image']) . "',
    '" . $conn->real_escape_string($data['cover_charge']) . "',
    '" . $conn->real_escape_string($data['date']) . "',
    '" . $conn->real_escape_string($data['start_time']) . "',
    '" . $conn->real_escape_string($data['event_type']) . "',
    '" . $conn->real_escape_string($data['age_restriction']) . "',
    '" . $conn->real_escape_string($data['description']) . "',
    '" . $conn->real_escape_string($data['host_email']) . "',
    'false'
  )";
  $status = dbQuery($theQuery);
  if ($status === FALSE) {
    return $status;
  } else {
    $url = isLocalInstall() ? 'http://localhost:8888/diymke/dashboard/moderation' : 'http://diymke.org/dashboard/moderation';
    $message = '
<html>
  <head>
    <title>DIY:MKE: New Event In Moderation Queue</title>
  </head>
  <body>';
    $message .= '<p>There is a new event in the moderation queue at DIY:MKE. Go check it out at ' . $url . '</p>';
    $message .= '
  </body>
</html>';
    $contact = array(
      'email' => 'no-reply@diymke.org',
      'subject' => 'DIY:MKE: New Event In Moderation Queue',
      'message' => $message
    );
    contact($contact);
    return true;
  }
}

function getEvent($id) {
  $query = "SELECT * FROM `events` WHERE `id` = $id";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res->fetch_assoc();
  }
}

function getEvents() {
  $query = "SELECT * FROM `events` WHERE `is_verified` = 1 AND `is_moderated` = 1 ORDER BY `date` ASC";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function getNextEvent() {
  $query = "SELECT * FROM `events` ORDER BY `date` ASC LIMIT 1";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res->fetch_assoc();
  }
}

function contact($vals) {
  $to = 'mods@diymke.org';
  $from = $vals['email'];
  if (isset($vals['subject'])) {
    $subject = $vals['subject'];
  } else {
    $subject = "New Contact Form From DIYMKE Website";
  }
  if (isset($vals['message'])) {
    $message = $vals['message'];
  } else {
    $message = "
  <html>
    <head>
      <title>" . $vals['subject'] . "</title>
    </head>
    <body>
      <p>
        You received a new message from DIYMKE's contact form.
      </p>
      <hr />
      <p>
    ";
    $message .= wordwrap($vals['message'], 70, "<br />");
    $message .= "
      </p>
      <blockquote>
        Signed - " . $vals['name'] . "
      <hr />
      <small>
        This email was automatically generated by DIYMKE
      </small>
    </body>
  </html>
    ";
  }
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= 'To: Nate Northway <mods@diymke.org>' . "\r\n";
  $headers .= 'From: <no-reply@diymke.org>' . "\r\n";
  mail($to, $subject, $message, $headers);
}

function search($term, $table) {
  $conn = conn();
  if (!isset($term) || !isset($table)) {
    return false;
  }
  $cleanTerm = $conn->real_escape_string($term);
  $query = "SELECT * FROM `" . $table . "` WHERE `name` LIKE '%" . $cleanTerm . "%' OR `location` LIKE '%" . $cleanTerm . "%' OR `description` LIKE '%" . $cleanTerm . "%' OR `genres` LIKE '%" . $cleanTerm . "%' ORDER BY `name` ASC";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
}

function sendErrorReport($error, $function) {
  $subject = "DIYMKE: Error Report";
  $message = "DIYMKE: Error Report \r\n" . $error . "\r\nIn the function " . $function;
  $to = "mods@diymke.org";
  $from = "no-reply@diymke.org";
  $headers = 'From: no-reply@diymke.org' . "\r\n" .
    'Reply-To: no-reply@diymke.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);
}

function truncate($text) {
  return substr($text, 0, 100) . "...";
}

?>
