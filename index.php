<!DOCTYPE html>
<html>
<head>
	<title>Eventus</title>
	<meta charset='UTF-8'>
	<script src="jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Styles/styles.css">
	<link rel="stylesheet" type="text/css" href="Styles/navigation.css">
	<link rel="stylesheet" type="text/css" href="Styles/footer.css">
	<link rel="stylesheet" type="text/css" href="Styles/main.css">
	<link rel="stylesheet" type="text/css" href="Styles/promotion.css">
	<script src="utils.js"></script>
</head>
<body>
	<?php include_once('navigation.php'); ?>
	<?php include_once('mainPage.php'); ?>
	<?php include_once('footer.php'); ?>

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
