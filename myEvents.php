<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['start'])){
  header("Location: index.php");
  die();
}
?>
<html>
<?php include('head.php'); ?>
<body>
	<?php include('navigation.php'); ?>
  <?php
    $db = new PDO('sqlite:Database/data.db');

    /* Run query to find events joined by the user */
    $tmp = $db->query('SELECT event.id, event.name, event.dateOfEvent, typeOfEvent.type FROM
    user JOIN event JOIN eventUser JOIN typeOfEvent WHERE
    user.id = eventUser.userId AND event.id = eventUser.eventId AND typeOfEvent.id = event.type AND user.id = ?
    ORDER BY date(event.dateOfEvent) DESC');
    $tmp->execute(array($_SESSION['id']));
    $events = $tmp->fetchAll();

    /* Run query to find events created by the user */
    $tmp = $db->query('SELECT event.id, event.name, event.dateOfEvent, typeOfEvent.type FROM
    user JOIN event JOIN typeOfEvent WHERE
    event.ownerId = user.id AND typeOfEvent.id = event.type AND user.id = ?');
    $tmp->execute(array($_SESSION['id']));
    $myEvents = $tmp->fetchAll();

    ?>

    <div id="content-events">
      <!-- JOINED EVENTS */ -->
      <div id="joined-events-area">
        <div class="events-section-title"> JOINED EVENTS </div>
        <?php foreach($events as $event) {  ?>
            <div class="events-section-content" data-id="' <?=$event[0]?> '">
              <img src="images/defaultImage.jpeg">
              <div class="events-content">
                <div class="events-content-title"> <?=$event[1]?> </div>
                <div class="events-content-date"> Date:  <?=$event[2]?> </div>
                <div class="events-content-type"> Type: <?=$event[3]?> </div>
                <a href="cancelJoinEvent.php/?id=<?=$event[0]?>"> <div id="cancel-join-event" class="events-content-cancel"> <i class="fa fa-times"></i> cancel </div> </a>
              </div>
            </div>
        <?php } ?>
      </div>
      <!-- USER EVENTS -->
      <div id="joined-events-area">
        <div class="events-section-title events-section-title-right"> MY EVENTS </div>
        <?php foreach($myEvents as $event) { ?>
            <div class="events-section-content" data-id="' <?=$event[0]?> '">
              <img src="images/defaultImage.jpeg">
              <div class="events-content events-content-right">
                <div class="events-content-title"> <?=$event[1]?> </div>
                <div class="events-content-date"> Date: <?=$event[2]?> </div>
                <div class="events-content-type"> Type: <?=$event[3]?> </div>
                <a href="cancelEvent.php/?id=<?=$event[0]?>"> <div id="cancel-join-event" class="events-content-cancel"> <i class="fa fa-times"></i> cancel </div> </a>
              </div>
            </div>
        <?php } ?>
      </div>
    <div id="events-button"> <input id="events-more" type="button" value="More"> </div>
    </div>

	<?php include('footer.php'); ?>

  <!--Awesome scripts!-->
	<script>
			$("#logout").click(logout);
			$("#userNameNav").click(openMenu);
			$("#myEventsLink").click();
	</script>
	<script src="Animations.js"> </script>
</body>
</html>
