<?php
  $db = new PDO('sqlite:Database/data.db');
  $pid = $_POST["pid"];
  $eid = $_POST["eid"];

  /* Update user profile in database */
  $tmp = $db->prepare('DELETE FROM eventPhoto WHERE id = ?');
  $tmp->execute(array($pid));
  foreach (glob("images/eventGalleryPhotos/egp-" . $eid . "-" . $pid . ".*") as $filename) {
    unlink($filename);
  }
  header("Location: eventGallery.php?eid=" . $eid);
  die();
 ?>
