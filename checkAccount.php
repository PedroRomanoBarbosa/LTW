<?php
  $db = new PDO('sqlite:Database/data.db');
  $username = $_POST['username'];
  $password = $_POST['password'];

  /* Verify if the user already exists */
  $tmp = $db->query('SELECT * FROM user WHERE user.username = ? LIMIT 1');
  $tmp->execute(array($username));
  $user = $tmp->fetch();

  if(count($user) == 1){
    echo 'Authentication failed!';
    exit;

  /* If the username exists compare with the password */
  }else {
    if(password_verify($password, $user["password"])){
      session_start();
      $_SESSION['start'] = true;
      $_SESSION['username'] = $user['username'];
      $_SESSION['id'] = $user['id'];
      $_SESSION['imagePath'] = $user['imagePath'];
      echo "login";
      exit();
    }else {
      echo 'Authentication failed!';
      exit();
    }
  }
?>
