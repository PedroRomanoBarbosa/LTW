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
  <link rel="stylesheet" type="text/css" href="Styles/Styles.css">
  <link rel="stylesheet" type="text/css" href="Styles/myEvents.css">
  <link rel="stylesheet" type="text/css" href="Styles/navigation.css">
  <link rel="stylesheet" type="text/css" href="Styles/footer.css">
  <script src="utils.js"></script>
</head>
<body>
	<?php include_once('navigation.php'); ?>
  <?php
    $db = new PDO('sqlite:Database/data.db');

    /* Run query to find events joined by the user */
    $tmp = $db->query('SELECT event.id, event.name, event.dateOfEvent, typeOfEvent.type, event.image, event.imagePath FROM
    user JOIN event JOIN eventUser JOIN typeOfEvent WHERE
    user.id = eventUser.userId AND event.id = eventUser.eventId AND typeOfEvent.id = event.typeId AND user.id = ?
    ORDER BY event.dateOfEvent ASC');
    $tmp->execute(array($_SESSION['id']));
    $events = $tmp->fetchAll();

    /* Run query to find events created by the user */
    $tmp = $db->query('SELECT event.id, event.name, event.dateOfEvent, typeOfEvent.type, event.image, event.imagePath FROM
    user JOIN event JOIN typeOfEvent WHERE
    event.ownerId = user.id AND typeOfEvent.id = event.typeId AND user.id = ?
    ORDER BY event.dateOfEvent ASC');
    $tmp->execute(array($_SESSION['id']));
    $myEvents = $tmp->fetchAll();
    ?>

    <div id="content-events">
      <a id="create-event-button" href="createEvent.php"> <i class="fa fa-plus-circle"></i> CREATE A NEW EVENT </a>
      <!-- JOINED EVENTS */ -->
      <div id="joined-events-area">
        <div class="events-section-title"> JOINED EVENTS </div>
        <?php foreach($events as $event) {  ?>
             <div class="events-section-content" data-index="<?=$joinedIndex?>" data-id="<?=$event[0]?>">
              <?php if($event[4] == 1){
                  echo "<img src='" . $event[5] . "'>";
                }else if($event[4] == 0){
                  echo "<img src='images/defaultImage.jpeg'>";
                }
                ?>
              <div class="events-content">
                <div class="events-content-title"> <?=$event[1]?> </div>
                <div class="events-content-date"> Date:  <?=$event[2]?> </div>
                <div class="events-content-type"> Type: <?=$event[3]?> </div>
                <a href="cancelJoinEvent.php/?id=<?=$event[0]?>"> <i class="fa fa-times"></i> cancel </a>
              </div>
            </div>
        <?php } ?>
      </div>
      <!-- USER EVENTS -->
      <div id="created-events-area">
        <div class="events-section-title events-section-title-right"> MY EVENTS </div>
        <?php
        foreach($myEvents as $event) { ?>
            <div class="events-section-content" data-index="<?=$createdIndex?>" data-id="<?=$event[0]?>">
              <?php if($event[4] == 1){
                  echo "<img src='" . $event[5] . "'>";
                }else if($event[4] == 0){
                  echo "<img src='images/defaultImage.jpeg'>";
                }
              ?>
              <div class="events-content events-content-right">
                <div class="events-content-title"> <?=$event[1]?> </div>
                <div class="events-content-date"> Date: <?=$event[2]?> </div>
                <div class="events-content-type"> Type: <?=$event[3]?> </div>
                <a href="cancelEvent.php/?id=<?=$event[0]?>">  <i class="fa fa-times"></i> cancel </a>
              </div>
            </div>
      <?php } ?>
      </div>
    <div id="events-button"> <input id="events-more" type="button" value="More"> </div>
    </div>

	<?php include_once('footer.php'); ?>

  <!--Awesome scripts!-->
  <?php
    echo '<script> var joinedEventsLenght =' . count($events) .';
                   var createdEventsLength =' . count($myEvents) .';</script>';
  ?>
	<script>
  $( document ).ready(function() {
    var joinedLimit = 3;
    var createdLimit = 3;
    $('#joined-events-area > .events-section-content').each(function(index) {
      if(index < 3){
        $(this).css("display", "block");
      }
    });
    $('#created-events-area > .events-section-content').each(function(index) {
      if(index < 3){
        $(this).css("display", "block");
      }
    });
    if(createdLimit >= createdEventsLength && joinedLimit >= joinedEventsLenght){
      $("#events-more").css("visibility","hidden");
    }
    $("#logout").click(logout);
    $("#userNameNav").click(openMenu);
    $(".events-section-content").click(cancelJoinEvent);
    $("#events-more").click(
      function(){
        createdLimit+=3;
        joinedLimit+=3;
        if(createdLimit >= createdEventsLength && joinedLimit >= joinedEventsLenght){
          $("#events-more").css("visibility","hidden");
        }
        $('#joined-events-area > .events-section-content').each(function(index) {
          if(index < joinedLimit){
            $(this).slideDown("fast");
          }
        });
        $('#created-events-area > .events-section-content').each(function(index) {
          if(index < createdLimit){
            $(this).slideDown("fast");
          }
        });
      }
    );
  });
	</script>
</body>
</html>
