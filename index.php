<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body>
	<?php include('navigation.php'); ?>
	<?php include('footer.php'); ?>
	<script>
	<?php if(isset($_SESSION['start'])){
		echo '$("#logout").click(logout);';
	}else {
		echo '$("#login").click(login);';
		echo '$("#username, #password").on("change keyup paste", hideError);';
	}
	?>
	</script>
</body>
</html>
