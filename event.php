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
    $eventId = $_GET['eid'];
    $db = new PDO('sqlite:Database/data.db');

    /* Run query to find event */
    $tmp = $db->query('SELECT * FROM event WHERE event.id = ?');
    $tmp->execute(array($eventId));
    $event = $tmp->fetch();

    /* Run query to find event's type */
    $tmp = $db->query('SELECT typeOfEvent.type FROM typeOfEvent WHERE typeOfEvent.id = ?');
    $tmp->execute(array($event["type"]));
    $type = $tmp->fetch();

    /* Run query to find event's owner's */
    $tmp = $db->query('SELECT user.id, user.username FROM user WHERE user.id = ?');
    $tmp->execute(array($event["ownerId"]));
    $owner = $tmp->fetch();

    /* Run query to find event's participants */
    $tmp = $db->query('SELECT user.id, user.username FROM user JOIN eventUser WHERE eventUser.userId = user.id AND eventUser.eventId = ?');
    $tmp->execute(array($event["id"]));
    $participants = $tmp->fetchAll();
    ?>

  <section id="event-main-area">
    <header>
      <?php if($event["image"] == 1){
          echo '<img id="eventImage" src=' . $event["imagePath"] . '>';
        }else if($event["image"] == 0){
          echo '<img id="eventImage" src=images/defaultImage.jpeg>';
        }
      ?>
      <h1> <?=$event["name"]?> </h1>
      <h2> Type: <?=$type["type"]?> </h2>
      <h4> Created by: <a href=""> <?=$owner["username"]?> </a> <h4>
    </header>
    <main>
      <h3>Description: </h3>
      <p> </p>
    <main>
    <aside>
      <?php foreach ($participants as $user) { ?>
        <section> <?=$user['username']?> </section>
      <?php } ?>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
      <section> <?=$user['username']?> </section>
    </aside>
  </section>

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
