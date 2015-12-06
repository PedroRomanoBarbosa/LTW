<?php
  $db = new PDO('sqlite:Database/data.db');
  $eid = $_POST["eid"];

  /* If the user didn't select anything */
  if($_FILES["galleryFile"]["error"] == 4){
    header("Location: eventGallery.php?eid=" . $eid);
    die();
  }else {
    $uploadOk = 1;
    $imageFileType = pathinfo($_FILES["galleryFile"]["name"],PATHINFO_EXTENSION);
    $target_dir = "images/eventGalleryPhotos/";

    // Check file size
    if ($_FILES["galleryFile"]["size"] > 1000000) {
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
      header("Location: eventGallery.php?eid=" . $eid);
      die();
    // if everything is ok, try to upload file
    } else {
      /* Update user profile in database */
      $tmp = $db->prepare('INSERT INTO eventPhoto (eventId) VALUES (?)');
      $tmp->execute(array($eid));
      $pid = $db->lastInsertId();
      $target_file = $target_dir . basename("egp-" . $eid . "-" . $pid);
      $tmp = $db->prepare('UPDATE eventPhoto SET imagePath = ? WHERE id = ?');
      $tmp->execute(array($target_file . "." . $imageFileType, $pid));
      foreach (glob($target_file . ".*") as $filename) {
        unlink($filename);
      }
      move_uploaded_file($_FILES["galleryFile"]["tmp_name"], $target_file . "." . $imageFileType);
      header("Location: eventGallery.php?eid=" . $eid);
      die();
    }
  }

 ?>
