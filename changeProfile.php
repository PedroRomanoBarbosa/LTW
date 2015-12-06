<?php
  $db = new PDO('sqlite:Database/data.db');

  /* If user clicked cancel */
  if(isset($_POST["cancelProfileEdit"]) && $_POST["cancelProfileEdit"] == "Cancel"){
    header("Location: profile.php?uid=" . $_POST["uid"] . "&nav=profile");
    die();
  }

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
    $imageFileType = pathinfo($_FILES["uploadFile"]["name"],PATHINFO_EXTENSION);
    $target_dir = "images/userImages/";
    $target_file = $target_dir . basename("userImage" . $_POST["uid"]);

    // Check file size
    if ($_FILES["uploadFile"]["size"] > 1000000) {
     echo "Sorry, your file is too large.";
     $uploadOk = 0;
    }

    // Allow certain file formats
    echo $imageFileType;
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      foreach (glob($target_file . ".*") as $filename) {
        unlink($filename);
      }
      if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file . "." . $imageFileType)) {
        /* Update user profile in database */
        $tmp = $db->prepare('UPDATE user SET name = ?, biography = ?, image = 1, imagePath = ? WHERE id = ?');
        $tmp->execute(array($name, $biography, $target_file . "." . $imageFileType, $_POST["uid"]));
        header("Location: profile.php?uid=" . $_POST["uid"] . "&nav=profile");
        die();
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    }
  }
?>
