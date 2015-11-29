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
    $tmp = $db->prepare('SELECT * FROM event WHERE event.id = ?');
    $tmp->execute(array($eventId));
    $event = $tmp->fetch();

    /* Run query to find event's type */
    $tmp = $db->prepare('SELECT typeOfEvent.type FROM typeOfEvent WHERE typeOfEvent.id = ?');
    $tmp->execute(array($event["type"]));
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
    $userInEvent = $tmp->fetchAll();
    $inTheEvent = true;
    if($userInEvent == 0){
      $inTheEvent = false;
    }
    ?>



  <!-- EVENT AREA -->
  <section id="event-main-area">
    <?php if($event["image"] == 1){
        echo '<img id="eventImage" src=' . $event["imagePath"] . '>';
      }else if($event["image"] == 0){
        echo '<img id="eventImage" src=images/defaultImage.jpeg>';
      }
    ?>
    <header>
      <h1> <?=$event["name"]?> </h1>
      <h2> Date: <?=$event["dateOfEvent"]?> </h2>
      <h3> Type: <?=$type["type"]?> </h2>
      <h4> Created by: <a href=<?= 'profile.php?uid=' . $event["ownerId"] ?>> <?=$owner["username"]?> </a> </h4>
    </header>
    <main>
      <h3> Description: </h3>
      <p> <?=$event["description"]?> </p>
      <div>
          <div>
            <h3> <?=count($participants)?> people going </h3>
            <?php if($event["ownerId"] == $_SESSION["id"]){
                echo '<a href=""> CANCEL </a>';
            }else {
              if($inTheEvent){
                echo '<a href=""> WITHDRAW </a>';
              }else {
                echo '<a href=""> JOIN </a>';
              }
            }
            ?>
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
    </main>
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
