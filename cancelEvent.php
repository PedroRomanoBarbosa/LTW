<?php
  $db = new PDO('sqlite:Database/data.db');
  $eventId = $_POST['id'];

  /* Deletes event */
  $tmp = $db->prepare('DELETE FROM event WHERE id = ?');
  $tmp->execute(array($eventId));
  header("Location: myEvents.php");
  exit;
?>
