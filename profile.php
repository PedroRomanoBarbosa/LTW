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
    $userId = $_GET['uid'];
    $db = new PDO('sqlite:Database/data.db');

    /* Run query to find user */
    $tmp = $db->prepare('SELECT * FROM user WHERE user.id = ?');
    $tmp->execute(array($userId));
    $user = $tmp->fetch();

    /* Count the number of events the user is going to */
    $tmp = $db->prepare('SELECT eventUser.eventId FROM user JOIN eventUser WHERE user.id = ? AND user.id = eventUser.userId');
    $tmp->execute(array($userId));
    $events = $tmp->fetchAll();

    /* Get created events */
    $tmp = $db->prepare('SELECT event.id, event.name, event.dateOfEvent, typeOfEvent.type, event.image, event.imagePath FROM
    user JOIN event JOIN typeOfEvent WHERE
    event.ownerId = user.id AND typeOfEvent.id = event.type AND user.id = ?
    ORDER BY event.dateOfEvent ASC');
    $tmp->execute(array($userId));
    $createdEvents = $tmp->fetchAll();

  ?>

  <!-- PROFILE AREA -->
  <section id="profile-area">
    <section id="user-info">
      <header>
        <img src=<?=$user["imagePath"]?> alt="profilePicture"/>
        <section>
          <h2><?=$user["username"]?></h2>
          <h3>Name: <?=$user["name"]?> </h3>
          <h4>events joined: <?=count($events)?> </h4>
        </section>
        <div class="floatClear"></div>
      </header>
      <article>
        <h1> About: </h1>
        <p> This is a description </p>
      </article>
    </section>
    <section id="user-events">
      <header>
        <h1> Created Events </h1>
      </header>
      <section>
        <?php foreach ($createdEvents as $createdEvent) { ?>
          <a href=<?= 'event.php?eid=' . $createdEvent["id"] ?> >
            <h2> <?=$createdEvent["name"]?> </h2>
            <h3> <?=$createdEvent["dateOfEvent"]?> </h3>
            <h4> Type: <?=$createdEvent["type"]?> </h4>
          </a>
        <?php } ?>
      <!-- events -->
      </section>
    </section>
    <div class="floatClear"></div>
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
