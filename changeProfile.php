<?php
  $db = new PDO('sqlite:Database/data.db');

  print_r($_POST);
  print_r($_FILES);

  /* Get new name */
  $name = trim($_POST["newName"]);
  /* Get new biography */
  $biography = trim($_POST["newBiography"]);

  /* Check image */
  $image = 1;
  if(isset($_POST["defaultImage"])){
    $image = 0;
  }

  /* If the user selected to rest to default image */
  if($image == 0){
    $tmp = $db->prepare('UPDATE user SET name = ?, biography = ?, image = 0, imagePath = "images/defaultUserImage.png" WHERE id = ?');
    $tmp->execute(array($name, $biography, $_POST["uid"]));
    header("Location: profile.php?uid=" . $_POST["uid"] . "&nav=profile");
    die();
  /* If the user didn't select anything */
  }else if($_FILES["uploadFile"]["error"] == 4){
    $tmp = $db->prepare('UPDATE user SET name = ?, biography = ? WHERE id = ?');
    $tmp->execute(array($name, $biography, $_POST["uid"]));
    header("Location: profile.php?uid=" . $_POST["uid"] . "&nav=profile");
    die();
  }else {
    $uploadOk = 1;
    $target_dir = "images/userImages/";
    $target_file = $target_dir . basename($_FILES["uploadFile"]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check file size
    if ($_FILES["uploadFile"]["size"] > 500000) {
     echo "Sorry, your file is too large.";
     $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
          echo "The file ". $target_file . " has been uploaded.";
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    }

    /* Update user profile in database */
    $tmp = $db->prepare('UPDATE user SET name = ?, biography = ?, image = 1, imagePath = ? WHERE id = ?');
    $tmp->execute(array($name, $biography, $target_file, $_POST["uid"]));
    //header("Location: profile.php?uid=" . $_POST["uid"] . "&nav=profile");
    //die();
  }
?>
