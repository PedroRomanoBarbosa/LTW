<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body>
	<?php include('navigation.php'); ?>
	<?php include('mainPage.php'); ?>
	<?php include('footer.php'); ?>

	<!--Awesome scripts!-->
	<script>
		<?php if(isset($_SESSION['start'])){
			echo '$("#logout").click(logout);';
			echo '$("#userNameNav").click(openMenu);';
			echo '$("#myEventsLink").click();';
		}else {
			echo '$("#login").click(login);';
			echo '$("#username, #password").on("change keyup paste", hideError);';
			echo '$("#reg").click(openRegist);';
			echo '$("#usernameReg,#passwordReg").on("change keyup paste",{flag: flag}, validate);';
			echo '$("#submit").click({flag: flag}, submit);';
		}
		?>
	</script>
	<script src="Animations.js"> </script>
</body>
</html>
