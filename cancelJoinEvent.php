<?php
  $db = new PDO('sqlite:Database/data.db');
  $eventId = $_POST['id'];
  session_start();
  $userId = $_SESSION['id'];

  /* Deletes connection between event and the user */
  $tmp = $db->prepare('DELETE FROM eventUser WHERE userId = ? AND eventId = ?');
  $tmp->execute(array($userId,$eventId));
  header("Location: event.php?eid=" . $eventId);
  exit;
?>
