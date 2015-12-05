<?php
  $db = new PDO('sqlite:Database/data.db');
  $name = $_POST['nameReg'];
  $username = $_POST['usernameReg'];
  $password = $_POST['passwordReg'];

  /* Verify if the user already exists */
  $tmp = $db->prepare('SELECT * FROM user WHERE user.username = ?');
  $tmp->execute(array($username));
  $names = $tmp->fetchAll();

  /* If there is already such name */
  if(count($names) != 0){
      echo 'Username already exists!';
      die;
  /* If there isn't */
  }else {
    /* Generate hash with salt */
    $hash = password_hash($password,PASSWORD_BCRYPT);
    /* Insert data in the database */
    $tmp = $db->prepare('INSERT INTO user (name,username,password,image,imagePath,biography) VALUES  (?, ?, ?, ?, ?, ?)');
    $tmp->execute(array($name,$username,$hash,1,"images/deafultUserImage.png",""));
    echo "valid";
  }
?>
