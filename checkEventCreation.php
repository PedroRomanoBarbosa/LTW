<?php
  session_start();

  $eventName = $_POST['event-name'];
  if($eventName == ""){
	  $_SESSION['ERROR'] = "The name of the event is empty";
	  header("Location: createEvent.php");
	  die();
  }

  $eventYear = $_POST['event-year'];
  if(! (isset($eventYear))){
	  $_SESSION['ERROR'] = "The year of the event is not valid";
	  header("Location: createEvent.php");
	  die();
  }
  if($eventYear < 10){
    $eventYear = "0" . $eventYear;
  }

  $eventMonth = $_POST['event-month'];
  if(! (isset($eventMonth))){
	  $_SESSION['ERROR'] = "The month of the event is not valid";
	  header("Location: createEvent.php");
	  die();
  }
  if($eventMonth < 10){
    $eventMonth = "0" . $eventMonth;
  }

  $eventDay = $_POST['event-day'];
  if(! (isset($eventDay))){
	  $_SESSION['ERROR'] = "The day of the event is not valid";
	  header("Location: createEvent.php");
	  die();
  }
  if($eventDay < 10){
    $eventDay = "0" . $eventDay;
  }

  $eventHour = $_POST['event-hour'];
  if(! (isset($eventHour))){
	  $_SESSION['ERROR'] = "The hour of the event is not valid";
	  header("Location: createEvent.php");
	  die();
  }
  if($eventHour < 10){
    $eventHour = "0" . $eventHour;
  }

  $eventMinutes = $_POST['event-minutes'];
  if(! (isset($eventMinutes))){
	  $_SESSION['ERROR'] = "The minutes of the event are not valid";
	  header("Location: createEvent.php");
	  die();
  }
  if($eventMinutes < 10){
    $eventMinutes = "0" . $eventMinutes;
  }

  $eventType = $_POST['event-type'];
  if(! (isset($eventType))){
	  $_SESSION['ERROR'] = "The type of the event is not valid";
	  header("Location: createEvent.php");
	  die();
  }

  $eventDescription = $_POST['event-description'];
  if($eventDescription == ""){
	  $_SESSION['ERROR'] = "The description of the event is empty";
	  header("Location: createEvent.php");
	  die();
  }

  $eventImage = $_POST['event-image'];
  if($eventImage == "images/defaultImage.jpeg"){
	  $isDefault = 0;
  }else{
	  $isDefault = 1;
  }

  $db = new PDO('sqlite:Database/data.db');
  $tmp = $db->prepare('INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES  (?, ?, ?, ?, ?, ?, ?)');
  $tmp->execute(array($_SESSION['id'],$eventName,$isDefault,"dummy",$eventYear."-".$eventMonth."-".$eventDay." ".$eventHour.":".$eventMinutes,$eventDescription,$eventType));

  $eid = $db->lastInsertId();
  $imageFileType = pathinfo($_FILES["event-image"]["name"],PATHINFO_EXTENSION);
  move_uploaded_file($_FILES["event-image"]["tmp_name"], "images/eventImages/eventImage" . $eid . "." . $imageFileType);
  $tmp = $db->prepare('UPDATE event SET imagePath = ? WHERE id = ?');
  $tmp->execute(array("images/eventImages/eventImage" . $eid . "." . $imageFileType, $eid));

  header("Location: myEvents.php");
  die();
?>
