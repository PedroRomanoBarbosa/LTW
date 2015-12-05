<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['start'])){
  header("Location: index.php");
  die();
}
?>
<html>
<head>
  <title>Eventus</title>
  <meta charset='UTF-8'>
  <script src="jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="Styles/styles.css">
  <link rel="stylesheet" type="text/css" href="Styles/editEvent.css">
  <link rel="stylesheet" type="text/css" href="Styles/navigation.css">
  <link rel="stylesheet" type="text/css" href="Styles/footer.css">
  <script src="utils.js"></script>
</head>
<body>
  <?php include_once('navigation.php'); ?>
  <?php
    $eventId = $_GET['eid'];
    $db = new PDO('sqlite:Database/data.db');

    /* Run query to find event */
    $tmp = $db->prepare('SELECT * FROM event WHERE event.id = ?');
    $tmp->execute(array($eventId));
    $event = $tmp->fetch();

    /* Run query to find event's type */
    $tmp = $db->prepare('SELECT typeOfEvent.type FROM typeOfEvent WHERE typeOfEvent.id = ?');
    $tmp->execute(array($event["typeId"]));
    $type = $tmp->fetch();

    /* Run query to find event's owner's */
    $tmp = $db->prepare('SELECT user.id, user.username FROM user WHERE user.id = ?');
    $tmp->execute(array($event["ownerId"]));
    $owner = $tmp->fetch();

    /* Get types of events */
    $tmp = $db->prepare('SELECT * FROM typeOfEvent');
    $tmp->execute();
    $eventTypes = $tmp->fetchAll();

    /* Get hours and minutes */
    list($date, $time) = explode(' ', $event["dateOfEvent"]);
    list($hour, $minutes) = explode(':', $time);
    ?>



  <!-- EDIT EVENT AREA -->
  <section id="edit-event-main-area" data-eid=<?php echo $event["id"]; ?>>
    <header>
      <h1> Edit your event here! </h1>
    </header>
    <form id="edit-form" action="changeEvent.php" method="post" enctype="multipart/form-data">
      <label>Image:</label>
      <br/>
      <img id="image-preview" src=<?php echo $event["imagePath"]; ?> alt="event-image" />
      <br/>
      <input type="checkbox" name="defaultImage" value="check">
      Reset to default image or
      <input id="event-file" type="file" name="uploadFile" />
      <br/>
      <label>Name:</label>
      <input id="new-name" type="text" name="newName" <?php echo 'value="' . $event["name"] .'"'; ?>/>
      <br/>
      <label>Type:</label>
      <select name="type">
        <?php foreach ($eventTypes as $eventType) { ?>
          <option value=<?=$eventType["id"]?> <?php if($event["typeId"] == $eventType["id"]){ echo 'selected="selected"'; }?>> <?=$eventType["type"]?> </option>
        <?php } ?>
      </select>
      <br/>
      <label>Date:</label>
      <input type="date" name="newDate" value=<?=$event["dateOfEvent"]?>/>
      <label>Time:</label>
      <select name="hour">
        <?php for ($i=0; $i < 24; $i++) { ?>
          <option value=<?=$i?> <?php if( $i == $hour ){ echo 'selected="selected"'; } ?> > <?=$i?> </option>
        <?php } ?>
      </select>
      <label> h : </label>
      <select name="minutes" >
        <?php for ($i=0; $i < 60; $i++) { ?>
          <option value=<?=$i?> <?php if( $i == $hour ){ echo 'selected="selected"'; } ?> > <?=$i?> </option>
        <?php } ?>
      </select>
      <label> m </label>
      <br/>
      <label>Description: </label>
      <br/>
      <textarea id="new-description" name="newDescription" rows="8" cols="40"/><?=$event["description"]?></textarea>
      <section id="control-buttons">
        <input type="submit" name="saveButton" value="Save">
        <input id="cancel-button" type="button" name="cancelButton" value="Cancel">
      </section>
      <input type="hidden" name="eid" value=<?=$event["id"]?>>
    </form>
  </section>

	<?php include_once('footer.php'); ?>

  <!--Awesome scripts!-->
	<script>
			$("#logout").click(logout);
			$("#userNameNav").click(openMenu);
      $("#image-preview").css({display: "none"});

      $("#minutes").keyup(function(){
        alert("wfwe");
      });

      $("#image-preview").slideDown("fast");

      $("#event-file").change(function(){
        $("#image-preview").slideUp("fast");
        readURL(this);
        $("#image-preview").slideDown("fast");
      });

      $("#cancel-button").click(function(){
        location.href = "event.php?eid=" + $("#edit-event-main-area").data("eid");
      });

	</script>
	<script src="Animations.js"> </script>
</body>
</html>
