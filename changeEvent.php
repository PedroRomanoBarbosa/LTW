<?php
  $db = new PDO('sqlite:Database/data.db');

  /* Insert new comment in database */
  $tmp = $db->prepare("UPDATE event SET name = ?, dateOfEvent = ?, description = ?, typeId = ? WHERE id = ?");
  $tmp->execute(array($_POST["name"], $_POST["date"], $_POST["description"], $_POST["type"], $_POST["eid"]));
?>
