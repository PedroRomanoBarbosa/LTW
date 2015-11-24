<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body>
	<?php include('navigation.php'); ?>
	<?php include('mainPage.php'); ?>
	<?php include('footer.php'); ?>

	<!--Awesome scripts!-->
		<?php if(isset($_SESSION['start'])){ ?>
			<script>
			$("#logout").click(logout);
			$("#userNameNav").click(openMenu);
			$("#myEventsLink").click();
			</script>
		<?php }else { ?>
			<script>
			$("#login").click(login);
			$("#username, #password").on("change keyup paste", hideError);
			$("#reg").click(openRegist);
			$("#usernameReg,#passwordReg").on("change keyup paste",{flag: flag}, validate);
			$("#submit").click({flag: flag}, submit);
			</script>
	<?php	} ?>
	<script src="Animations.js"> </script>
</body>
</html>
