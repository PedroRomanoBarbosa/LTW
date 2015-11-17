<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body>
	<?php include('navigation.php'); ?>
	<?php include('footer.php'); ?>

	<!--Awesome scripts!-->
	<script>
	<?php if(isset($_SESSION['start'])){
		echo '$("#logout").click(logout);';
	}else {
		echo '$("#login").click(login);';
		echo '$("#username, #password").on("change keyup paste", hideError);';
	}
	?>
	</script>
	<script src="Animations.js"> </script>
</body>
</html>
