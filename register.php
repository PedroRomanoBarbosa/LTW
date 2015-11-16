<!DOCTYPE html>
<html>
	<?php include('head.php'); ?>
<body>
	<?php include('header.php'); ?>
	<form id="form" action="" method="post" autocomplete="on">
		* Username:
  	<input id="username" type="text" name="username" maxlength="20">
  	<br>
	  * Password:
	  <input id="password" type="password" name="password" maxlength="20">
		<br>
		<div id="errorBlock"> Valid </div>
		<input id="submit" type="button" value="Confirm">
	</form>
	<!--Scripts-->
	<?php include('footer.php'); ?>
	<script>
		$("#username,#password").on('change keyup paste',{flag: flag}, validate);
		$("#submit").click({flag: flag}, submit);
	</script>
</body>

</html>
