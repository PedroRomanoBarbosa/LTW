<?php
  $db = new PDO('sqlite:Database/data.db');

  /* Insert new comment in database */
  $tmp = $db->prepare('INSERT INTO comment (userId, eventId, content) VALUES (?,?,?)');
  $tmp->execute(array($_POST["userId"], $_POST["eventId"], $_POST["text"]));

  header('Location: ' . 'event.php?eid=' . $_POST["eventId"]);
?>
