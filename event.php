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
  <link rel="stylesheet" type="text/css" href="Styles/event.css">
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

    /* Run query to find event's participants */
    $tmp = $db->prepare('SELECT user.id, user.username, user.imagePath FROM user JOIN eventUser WHERE eventUser.userId = user.id AND eventUser.eventId = ?');
    $tmp->execute(array($event["id"]));
    $participants = $tmp->fetchAll();

    /* Run query to find event's comments */
    $tmp = $db->prepare('SELECT comment.userId, comment.content, user.username, user.imagePath FROM comment JOIN user WHERE ? = comment.eventId AND user.id = comment.userId');
    $tmp->execute(array($event["id"]));
    $comments = $tmp->fetchAll();

    /* Check if the actual user is going to the event */
    $tmp = $db->prepare('SELECT user.id FROM user JOIN eventUser WHERE eventUser.userId = user.id AND eventUser.userId = ? AND eventUser.eventId = ?');
    $tmp->execute(array($_SESSION["id"], $event["id"]));
    $userInEvent = $tmp->fetch();
    $inTheEvent = true;
    if($userInEvent == 0){
      $inTheEvent = false;
    }

    /* Get types of events */
    $tmp = $db->prepare('SELECT * FROM typeOfEvent');
    $tmp->execute();
    $eventTypes = $tmp->fetchAll();

    ?>



  <!-- EVENT AREA -->
  <section id="event-main-area" data-id=<?=$event["id"]?>>
    <?php if($event["image"] == 1){
        echo '<img id="eventImage" src=' . $event["imagePath"] . '>';
      }else if($event["image"] == 0){
        echo '<img id="eventImage" src=images/defaultImage.jpeg>';
      }
    ?>
    <input id="editButtonTest" type="submit" value="Edit">
    <header>
      <h1 id="eventName"> <?=$event["name"]?> </h1>
      <h2 id="eventDate"> Date: <?=$event["dateOfEvent"]?> </h2>
      <h3> Type: <?=$type["type"]?> </h2>
      <div id="radio" <?='data-id="' . $event["typeId"] . '"'?>>
        <h1> Type: </h1>
      <?php foreach ($eventTypes as $eventType) { ?>
        <input type="radio" name="type" value=<?=$eventType["id"]?>> <?=$eventType["type"]?>
        <br>
      <?php } ?>
      </div>
      <h4> Created by: <a href=<?= 'profile.php?uid=' . $event["ownerId"] ?>> <?=$owner["username"]?> </a> </h4>
    </header>
    <article>
      <h3> Description: </h3>
      <p id="eventDescription"> <?=$event["description"]?> </p>
      <div>
          <div>
            <h3> <?=count($participants)?> people going </h3>
          </div>
        <aside>
          <?php foreach ($participants as $user) { ?>
            <a href=<?= 'profile.php?uid=' . $user["id"] ?>>
              <img src=<?=$user["imagePath"] ?>>
              <h3> <?=$user['username']?> </h3>
              <div></div>
            </a>
          <?php } ?>
        </aside>
      </div>
      <footer>  </footer>
    </article>
    <?php
      if($_SESSION["id"] == $event["ownerId"]){ ?>
        <input id="editButton" type="submit" value="Edit">
        <div class="floatClear"></div>
    <?php } ?>
    <?php
    /* If its the owner of the event */
    if($event["ownerId"] == $_SESSION["id"]){
        /* If it is in the event */
        if($inTheEvent){
          echo '<form method="post" action="cancelJoinEvent.php"> <input type="hidden" name="id" value="' . $event["id"] . '"> <input id="withdraw-button" type="submit" value="WITHDRAW"> </form>';
        /* If its not */
        }else {
          echo '<form method="post" action="joinEvent.php"> <input type="hidden" name="id" value="' . $event["id"] . '"> <input id="join-button" type="submit" value="JOIN!"> </form>';
        }
        echo '<form method="post" action="cancelEvent.php"> <input type="hidden" name="id" value="' . $event["id"] . '"> <input id="cancel-button" type="submit" value="CANCEL EVENT"> </form>';
    }else {
      /* If it is in the event */
      if($inTheEvent){
        echo '<form method="post" action="cancelJoinEvent.php"> <input type="hidden" name="id" value="' . $event["id"] . '"> <input id="withdraw-button" type="submit" value="WITHDRAW"> </form>';
      /* If its not */
      }else {
        echo '<form method="post" action="joinEvent.php"> <input type="hidden" name="id" value="' . $event["id"] . '"> <input id="join-button" type="submit" value="JOIN!"> </form>';
      }
    }
    ?>
  </section>



  <h1 id="comment-begin"> <i class="fa fa-arrow-down"></i> Comment Section <i class="fa fa-arrow-down"></i> </h1>




  <!-- YOUR COMMENT SECTION -->
  <?php if($inTheEvent || ($_SESSION['id']) == $event['ownerId']){ ?>
    <section id="your-comment">
      <header>
        <img src=<?=$_SESSION["imagePath"] ?>>
        <h2> <?=$_SESSION['username']?> </h2>
      </header>
      <main>
        <h1> Comment here: </h1>
        <form action="comment.php" method="post">
          <textarea maxlength="600" rows="4" cols="50" name="text"> </textarea>
          <input type="hidden" name="userId" value=<?=$_SESSION["id"]?>>
          <input type="hidden" name="eventId" value=<?=$event["id"]?>>
          <input type="submit" value="Submit">
        </form>
        <footer></footer>
      </main>
    </section>
  <?php } ?>


  <!-- COMMENTS SECTION -->
    <?php foreach ($comments as $comment) { ?>
      <section id="users-comments-section">
        <header>
          <img src=<?=$comment["imagePath"] ?>>
          <a href= <?= "profile.php?uid=" . $comment["userId"] ?> > <?=$comment['username']?> </a>
        </header>
        <main>
          <textarea readonly="readonly"> <?=$comment['content']?> </textarea>
        </main>
      </section>
    <?php } ?>

	<?php include_once('footer.php'); ?>

  <!--Awesome scripts!-->
	<script>
			$("#logout").click(logout);
			$("#userNameNav").click(openMenu);
      $("#editButton").click(editEvent);
	</script>
	<script src="Animations.js"> </script>
</body>
</html>
