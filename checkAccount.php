<?php
  $db = new PDO('sqlite:data.db');
  $user = $db->prepare('SELECT * FROM news');
  echo "string";
  $stmt->execute();
  $result = $stmt->fetchAll();
?>
