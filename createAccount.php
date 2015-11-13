<?php
  $db = new PDO('sqlite:data.db');
  $username = $_POST['username'];
  $password = $_POST['password'];

  /* Verify if the user already exists */
  $tmp = $db->prepare('SELECT * FROM user WHERE user.username = ?');
  $tmp->execute(array($username));
  $names = $tmp->fetchAll();

  /* If there is already such name */
  if(count($names) != 0){
      echo 'Username already exists';
      die;
  /* If there isn't */
  }else {
    $tmp = $db->prepare('INSERT INTO user (username,password) VALUES  (?, ?)');
    $tmp->execute(array($username,$password));
    echo "valid";
  }
?>
