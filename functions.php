<?php

function conn() {
  return new mysqli("localhost", "diymkeor_diymke", "utrhf5cs!", "diymkeor_diymke");
  //return new mysqli("localhost", "root", "root", "diymke");
}

function dbQuery($q) {
  $conn = conn();
  if ($conn->connect_errno) {
    $error = "Failed to connect to MySQL: (Error " . $conn->connect_errno . ") " . $conn->connect_error;
    sendErrorReport($error);
  }

  $res = $conn->query($q);

  if ($res) {
    return $res;
  } else {
    $error = "Failed to submit query: (Error " . $conn->sqlstate . ") " . $conn->error;
    sendErrorReport($error);
    return false;
  }
}

function dbInsert($query) {
  $conn = conn();
  if ($conn->connect_errno) {
    $error = "Failed to connect to MySQL: (Error " . $conn->connect_errno . ") " . $conn->connect_error;
    sendErrorReport($error);

    if ($conn->query($query)) {
      return true;
    } else {
      $error = "Failed to submit query: (Error: " . $conn->sqlstate . ") " . $conn->error;
      sendErrorReport($error);
      return false;
    }
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
  if (strpos($string, "http://") === false || strpos($string, "https://") === false) {
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
    //insert the genres
    $genres = array();

    //collect the genres, store in local var
    $genres = explode(", ", $conn->real_escape_string($data['genres']));

    //get the inserted band's id
    $getQuery = "SELECT * FROM `bands` ORDER BY `id` DESC LIMIT 1";
    $result = dbQuery($getQuery);
    $band = $result->fetch_row();
    $bandID = $band[0];

    //for each genre
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
    //insert the genres
    $genres = array();

    //collect the genres, store in local var
    $genres = explode(", ", $conn->real_escape_string($data['genres']));

    //get the inserted band's id
    $getQuery = "SELECT * FROM `venues` ORDER BY `id` DESC LIMIT 1";
    $result = dbQuery($getQuery);
    $venue = $result->fetch_row();
    $venueID = $venue[0];

    //for each genre
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

function contact($vals) {
  $to = 'nate@natenorthway.com';
  $from = $vals['email'];
  if (isset($vals['subject'])) {
    $subject = $vals['subject'];
  } else {
    $subject = "New Contact Form From DIYMKE Website";
  }
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
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= 'To: Nate Northway <nate@natenorthway.com>' . "\r\n";
  $headers .= 'From: <no-reply@diymke.org>' . "\r\n";
  mail($to, $subject, $message, $headers);
}

function search($term, $table) {
  $conn = conn();

  $cleanTerm = $conn->real_escape_string($term);
  $query = "SELECT *
  FROM `" . $table . "`
  WHERE
  `name` LIKE '%" . $cleanTerm . "%' OR
  `location` LIKE '%" . $cleanTerm . "%' OR
  `description` LIKE '%" . $cleanTerm . "%' OR
  `genres` LIKE '%" . $cleanTerm . "%'
  ORDER BY `name` ASC";
  $res = dbQuery($query);
  if (!$res) {
    unset($res);
    return false;
  } else {
    return $res;
  }
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
