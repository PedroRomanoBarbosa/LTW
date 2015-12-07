<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['start'])){
  header("Location: index.php");
  die();
}
?>
<?php
  $db = new PDO('sqlite:Database/data.db');
  $eid = $_GET["eid"];

  /* Get photos from event */
  $tmp = $db->prepare('SELECT * FROM eventPhoto WHERE eventPhoto.eventId = ?');
  $tmp->execute(array($eid));
  $images = $tmp->fetchAll();

  /* Get event */
  $tmp = $db->prepare('SELECT * FROM event WHERE id = ?');
  $tmp->execute(array($eid));
  $event = $tmp->fetch();

 ?>
 <html>
 <head>
   <title>Eventus</title>
   <meta charset='UTF-8'>
   <script src="jquery-1.7.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="Styles/eventGallery.css">
   <link rel="stylesheet" type="text/css" href="Styles/navigation.css">
   <link rel="stylesheet" type="text/css" href="Styles/footer.css">
   <link href="Styles/lightbox.css" rel="stylesheet">
   <script src="utils.js"></script>
 </head>
 <body>
   <?php include_once("navigation.php") ?>
   <section id="gallery-area">
     <header>
       <a id="back-button" <?php echo "href='event.php?eid=" . $eid . "'"; ?>> <i class="fa fa-arrow-left"></i> Got back to the event's page </a>
       <?php if($_SESSION["id"] == $event["ownerId"]){ ?>
       <form id="add-form" action="addImageToGallery.php" method="post" enctype="multipart/form-data">
         <input type="file" name="galleryFile">
         <br/>
         <input type="hidden" name="eid" value=<?=$eid?>>
         <input id="add-button" type="submit" name="submitButton" value="+ Add Image">
       </form>
       <?php } ?>
     </header>
     <section id="images-section">
       <?php
       $index = 0;
       foreach ($images as $image) { ?>
         <?php if($index % 4 == 0){ ?>
           <?php if($index != 0) { ?>
             <div class="floatClear"> </div> </section>
           <?php } ?>
         <?php } ?>
        <?php if($index % 4 == 0){ ?>
          <?php if($index != count($images)) { ?>
            <section class="image-row">  <?php
          } ?>
        <?php } ?>
        <section class="image-section">
          <a href=<?=$image["imagePath"]?> data-lightbox="gallery">
            <img data-lightbox="gallery" class="gallery-image" src=<?=$image["imagePath"]?> <?php echo "alt='image with id " . $image["id"] . " of event with the id " . $image["eventId"] . "'";?> />
          </a>
          <?php if($_SESSION["id"] == $event["ownerId"]){ ?>
          <form action="deleteImageFromGallery.php" method="post">
            <input type="hidden" name="eid" value=<?=$eid?>>
            <input type="hidden" name="pid" value=<?=$image["id"]?>>
            <input type="submit" class="delete-button" value="&#10006; DELETE"/>
          </form>
          <?php } ?>
        </section>
        <?php if($index+1 == count($images)){ ?>
          <div class="floatClear"> </div> </section>
        <?php } ?>
       <?php $index++; } ?>
    </section>
    <div class="floatClear"> </div>
  </section>
   <?php include_once("footer.php"); ?>
   <!--Awesome scripts!-->
 	<script>
 			$("#logout").click(logout);
 			$("#userNameNav").click(openMenu);
 	</script>
 	<script src="Animations.js"> </script>
  <script src="lightbox.js"></script>
 </body>
