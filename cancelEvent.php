<?php
  $db = new PDO('sqlite:Database/data.db');
  $eventId = $_GET['id'];

  /* Deletes event */
  $tmp = $db->query('DELETE FROM event WHERE id = ?');
  $tmp->execute(array($eventId));
  header("Location: ../myEvents.php");
  die();
?>
