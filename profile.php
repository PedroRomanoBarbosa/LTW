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
  <link rel="stylesheet" type="text/css" href="Styles/profile.css">
  <link rel="stylesheet" type="text/css" href="Styles/navigation.css">
  <link rel="stylesheet" type="text/css" href="Styles/footer.css">
  <script src="utils.js"></script>
</head>
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
    event.ownerId = user.id AND typeOfEvent.id = event.typeId AND user.id = ?
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
          Name: <h3 id="profileName"> <?=$user["name"]?> </h3>
          <h4>events joined: <?=count($events)?> </h4>
        </section>
        <div class="floatClear"></div>
      </header>
      <article>
        <h1> About: </h1>
        <p id="profileDescription"> This is a description </p>
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
    <?php if($_SESSION["id"] == $user["id"]){ ?>
      <div id="edit-section"> <input id="editButton" type="button" value="Edit"> </div>
    <?php } ?>
    <div class="floatClear"> </div>
  </section>


	<?php include('footer.php'); ?>

  <!--Awesome scripts!-->
	<script>
			$("#logout").click(logout);
      var uid =
      <?php
        echo $_GET["uid"];
      ?>;
			$("#userNameNav").click(openMenu);
			$("#editButton").click(editProfile);
	</script>
	<script src="Animations.js"> </script>
</body>
</html>
