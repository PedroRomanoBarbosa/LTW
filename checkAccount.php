<?php
  $db = new PDO('sqlite:data.db');
  $username = $_POST['username'];
  $password = $_POST['password'];

  /* Verify if the user already exists */
  $tmp = $db->query('SELECT * FROM user WHERE user.username = ? LIMIT 1');
  $tmp->execute(array($username));
  $user = $tmp->fetch();

  if(count($user) == 1){
    echo 'invalid username!';
    exit;
  /* If the username exists compare with the password */
  }else {
    if($user['password'] == $password){
      session_start();
      $_SESSION['start'] = true;
      $_SESSION['username'] = $user['username'];
      $_SESSION['id'] = $user['id'];
      echo "login";
      exit;
    }else {
      echo 'Invalid password!';
      exit;
    }
  }
?>
