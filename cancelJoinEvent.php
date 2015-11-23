<?php
  $db = new PDO('sqlite:Database/data.db');
  $eventId = $_GET['id'];
  session_start();
  $userId = $_SESSION['id'];

  /* Deletes connection between event and the user */
  $tmp = $db->query('DELETE FROM eventUser WHERE userId = ? AND eventId = ?');
  $tmp->execute(array($userId,$eventId));
  header("Location: ../myEvents.php");
  die();
?>
