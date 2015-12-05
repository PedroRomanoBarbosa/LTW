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
    <nav id="profile-nav" data-nav=<?=$_GET["nav"]?>>
      <ul>
        <li id="nav-profile"><a href=<?="profile.php?uid=" . $userId . "&nav=profile"?>><i class="fa fa-user"></i> Profile</a></li>
        <li id="nav-events"><a href=<?="profile.php?uid=" . $userId . "&nav=events"?>><i class="fa fa-calendar-o"></i> Events</a></li>
        <?php if($_SESSION["id"] == $user["id"]){ ?>
          <li id="nav-edit"><a href=<?="profile.php?uid=" . $userId . "&nav=edit"?>><i class="fa fa-pencil"></i> Edit</a></li>
        <?php } ?>
      </ul>
    </nav>


    <!-- PROFILE -->
    <?php if($_GET["nav"] == "profile"){ ?>
      <section id="user-info">
        <header>
          <img id="profile-image" src=<?=$user["imagePath"]?> alt="profilePicture"/>
          <section>
            <h2><?=$user["username"]?></h2>
            Name: <h3 id="profileName"> <?=$user["name"]?> </h3>
            <h4>events joined: <?=count($events)?> </h4>
          </section>
          <div class="floatClear"></div>
        </header>
        <article>
          <h1> About Me: </h1>
          <p id="profileDescription"> <?=$user["biography"]?> </p>
        </article>
      </section>

    <!-- EVENTS CREATED -->
    <?php }else if($_GET["nav"] == "events"){ ?>
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



    <!-- EDIT  -->
    <?php }else if($_GET["nav"] == "edit" && $_SESSION["id"] == $user["id"]){ ?>
    <section id="user-edit">
      <header>
        Edit your profile here!
      </header>
      <form action="changeProfile.php" method="post" enctype="multipart/form-data">
        <label> Profile Image: </label>
        <br/>
        <?php if($user["image"] == 1){?>
          <img id="image-preview" src=<?=$user["imagePath"]?> alt="preview image"/>
        <?php }else{ ?>
          <img id="image-preview" src="images/defaultUserImage.png" alt="preview image"/>
        <?php } ?>
        <br/>
        <input type="checkbox" name="defaultImage" value="check"/> Reset to default image or
        <input type="file" name="uploadFile" id="upload-file" value="upload file"/>
        <br/>
        <label> Your name: </label>
        <br/>
        <input type="text" name="newName" id="new-name" value="<?php echo $user['name']; ?>"/>
        <br/>
        <label> About you:</label>
        <br/>
        <textarea name="newBiography" id="new-biography" maxlength="300"><?=$user["biography"]?></textarea>
        <br/>
        <section>
          <input type="submit" id="submit-button" name="submitProfileEdit" value="Save"/>
          <input type="submit" id="cancel-button" name="cancelProfileEdit" value="Cancel"/>
        </section>
        <input type="hidden" name="uid" value=<?=$user["id"]?>>
      </form>
    </section>
    <?php }else{
      header("Location: index.php");
    } ?>
    <div class="floatClear"> </div>
  </section>


	<?php include('footer.php'); ?>

  <!--Awesome scripts!-->
	<script>
			$("#logout").click(logout);
      var nav = $("#profile-nav").data("nav");
      switch (nav) {
        case "profile":
          $("#nav-profile").css("background-color","rgb(25,189,155)");
          $("#nav-profile > a").css("border-bottom","0.2rem solid white");
          break;
        case "events":
          $("#nav-events").css("background-color","rgb(25,189,155)");
          $("#nav-events > a").css("border-bottom","0.2rem solid white");
          break;
        case "edit":
          $("#nav-edit").css("background-color","rgb(25,189,155)");
          $("#nav-edit > a").css("border-bottom","0.2rem solid white");
          break;
      }
			$("#userNameNav").click(openMenu);
			$("#editButton").click(editProfile);

      $("#upload-file").change(function(){
        $("#image-preview").slideUp("fast");
        readURL(this);
        $("#image-preview").slideDown("fast");
      });
	</script>
	<script src="Animations.js"> </script>
</body>
</html>
