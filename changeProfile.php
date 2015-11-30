<?php
  $db = new PDO('sqlite:Database/data.db');
  /* Insert new comment in database */
  $tmp = $db->prepare('UPDATE user SET name = ? WHERE id = ?');
  $tmp->execute(array($_POST["name"], $_POST["userId"]));

  header('Location: ' . 'profile.php?eid=' . $_POST["userId"]);
?>
