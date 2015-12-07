<?php
  $db = new PDO('sqlite:Database/data.db');
  $eventId = $_POST['id'];

  /* Deletes event */
  $tmp = $db->exec("PRAGMA foreign_keys = ON");
  $tmp = $db->prepare('DELETE FROM event WHERE id = ?');
  $tmp->execute(array($eventId));
  foreach (glob("images/eventImages/eventImage" . $_POST["id"] . ".*") as $filename) {
    unlink($filename);
  }
  header("Location: myEvents.php");
?>
