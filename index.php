<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body>
	<?php include('header.php'); ?>
	<?php session_start();
				if(isset($_SESSION['start'])){
					echo '<h3> User: ' . $_SESSION['username'] . '</h3>';
					echo '<input id="logout" type="button" value="Log Out">';
				}else {
					echo '<h3> <a href="register.php"> Register account </a> </h3>
					<form action="" method="post" autocomplete="on">
						Username:
				  	<input id="username" type="text" name="username">
				  	<br>
					  Password:
					  <input id="password" type="password" name="password">
						<br>
						<div id="errorBlock"> Valid </div>
						<input id="login" type="button" value="Log In">
					</form>';
				}
	?>
	<?php include('footer.php'); ?>
	<script>
	<?php if(isset($_SESSION['start'])){
		echo '$("#logout").click(logout)';
	}else {
		echo '$("#login").click(login)';
	}
	?>
	</script>
</body>
</html>
