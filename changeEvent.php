<?php
  $db = new PDO('sqlite:Database/data.db');

  print_r($_POST);
  //print_r($_FILES);

  /* Get new name */
  $name = trim($_POST["newName"]);

  /* Get new biography */
  $description = trim($_POST["newDescription"]);

  /*Get type of event */
  $type = $_POST["type"];

  /* Check image */
  $image = 1;
  if(isset($_POST["defaultImage"])){
    $image = 0;
  }

  /* Check date */
  $date = $_POST["newDate"];
  if(intval($_POST["hour"]) < 10){
    $date = $date . " 0" . $_POST["hour"];
  }else{
    $date = $date . " " . $_POST["hour"];
  }
  if(intval($_POST["minutes"]) < 10){
    $date = $date . ":0" . $_POST["minutes"];
  }else{
    $date = $date . ":" . $_POST["minutes"];
  }

  /* If the user selected to reset to default image */
  if($image == 0){
    $tmp = $db->prepare('UPDATE event SET name = ?, description = ?, image = 0, imagePath = "images/defaultImage.jpeg", typeId = ?, dateOfEvent = ? WHERE id = ?');
    $tmp->execute(array($name, $description, $type, $date, $_POST["eid"]));
    header("Location: event.php?eid=" . $_POST["eid"]);
    die();

  /* If the user didn't select anything */
  }else if($_FILES["uploadFile"]["error"] == 4){
    $tmp = $db->prepare('UPDATE event SET name = ?, description = ?, typeId = ?, dateOfEvent = ? WHERE id = ?');
    $tmp->execute(array($name, $description, $type, $date, $_POST["eid"]));
    header("Location: event.php?eid=" . $_POST["eid"]);
    die();
  }else {
    $uploadOk = 1;
    $imageFileType = pathinfo($_FILES["uploadFile"]["name"],PATHINFO_EXTENSION);
    $target_dir = "images/eventImages/";
    $target_file = $target_dir . basename("eventImage" . $_POST["eid"]);

    // Check file size
    if ($_FILES["uploadFile"]["size"] > 1000000) {
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
      foreach (glob($target_file . ".*") as $filename) {
        unlink($filename);
      }
      if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file . "." . $imageFileType)) {
        /* Update user profile in database */
        $tmp = $db->prepare('UPDATE event SET name = ?, description = ?, image = 1, imagePath = ?, typeId = ?, dateOfEvent = ? WHERE id = ?');
        $tmp->execute(array($name, $description, $target_file . "." . $imageFileType, $type, $date, $_POST["eid"]));
        header("Location: event.php?eid=" . $_POST["eid"]);
        die();
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    }
}
?>
