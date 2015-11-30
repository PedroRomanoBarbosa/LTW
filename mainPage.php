<?php
  if(isset($_SESSION['start'])){
    include_once('main.php');
  }else {
?>
  <div id="promoArea">
    <div id="promoInfo">
      <div id="space"> </div>
      <div id="promoTitle">JOIN, CREATE AND DISCOVER</div>
      <div id="promoSubTitle"> - The best event organizer you will ever experience - </div>
      <div id="promoText"> EVENTUS is a platform that enables users to create, discover and join all sorts of events all over the world! </div>
      <input type="button" id="reg" value="JOIN NOW!"/>
    </div>
  </div>
  <div id="registerArea">
    <div id="registerFormArea">
      <?php include_once('register.php'); ?>
    </div>
  </div>
  <?php } ?>
