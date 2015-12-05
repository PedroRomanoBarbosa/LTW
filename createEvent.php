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
  <link rel="stylesheet" type="text/css" href="Styles/createEvent.css">
  <link rel="stylesheet" type="text/css" href="Styles/navigation.css">
  <link rel="stylesheet" type="text/css" href="Styles/footer.css">
  <script src="utils.js"></script>
</head>
<body>
	<?php include('navigation.php'); ?>

	<?php
		$db = new PDO('sqlite:Database/data.db');

		/* Get types of events */
		$tmp = $db->prepare('SELECT * FROM typeOfEvent');
		$tmp->execute();
		$eventTypes = $tmp->fetchAll();
  ?>
	<section id="create-event-title">
		Create Event
	</section>
	<section id="create-event-area">
		<form id="create-event-info" action="checkEventCreation.php" method="post">
			<div id="create-event-area-left">
				<div id="create-event-name">
					<strong>Event Name:</strong>
					<input type="text" name="event-name">
				</div>
				<div id="create-event-date">
					<strong>Event Date:</strong>
					<div id="create-event-date-date">
						<div>
							Year
							<select id="event-year" name="event-year">
								<option selected="selected" disabled="disabled">-------</option>
								<?php
									$actualYear = date('Y');
									for(;$actualYear <= 2100; $actualYear++){
								?>
									<option value=<?=$actualYear?>><?=$actualYear?></option>
								<?php } ?>
							</select>
						</div>
						<div>
							Month
							<select class="event-2char" id="event-month" name="event-month">
								<option selected="selected" disabled="disabled">----</option>
								<?php
									$monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
									foreach($monthList as $month){
								?>
									<option value=<?=$month?>><?=$month?></option>
								<?php } ?>
							</select>
						</div>
						<div>
							Day
							<select class="event-2char" id="event-day" name="event-day">
								<option selected="selected" disabled="disabled">----</option>
							</select>
							<script>
								var auxFunc = function() {
									var maxDay;

									var yearSelectObj = document.getElementById('event-year');
									var yearVal = yearSelectObj.options[yearSelectObj.selectedIndex].value;

									var monthSelectObj = document.getElementById('event-month');
									var monthVal = monthSelectObj.options[monthSelectObj.selectedIndex].value;

									if(yearVal != '-------' && monthVal != '----'){
										if(monthVal == 'Jan' || monthVal == 'Mar' || monthVal == 'May' || monthVal == 'Jul' || monthVal == 'Aug' || monthVal == 'Oct' || monthVal == 'Dec'){
											maxDay = 31;
										}else{
											if(monthVal == 'Feb'){
												if((yearVal % 4) == 0){
													maxDay = 29;
												}else{
													maxDay = 28;
												}
											}else{
												maxDay = 30;
											}
										}

										var selectObj = document.getElementById('event-day');
										while (selectObj.firstChild) {
											selectObj.removeChild(selectObj.firstChild);
										}

										var firstOptionObj = document.createElement('option');
										firstOptionObj.innerHTML = '----';
										selectObj.appendChild(firstOptionObj);

										for(var i=1; i<=maxDay; i++){
											var optionObj = document.createElement('option');
											optionObj.value = i;
											optionObj.innerHTML = i;
											selectObj.appendChild(optionObj);
										}

										selectObj.options[0].disabled = true;
										selectObj.options[0].selected = true;
									}
								};

								$('#event-year').on('change', auxFunc);
								$('#event-month').on('change', auxFunc);
							</script>
						</div>
						<br>
						<br>
					</div>
					<div id="create-event-date-time">
						Time
						<select class="event-2char" id="event-hour" name="event-hour">
							<option selected="selected" disabled="disabled">----</option>
							<?php
								$hourVal = 0;
								for(;$hourVal <= 24; $hourVal++){
							?>
								<option value=<?=$hourVal?>><?=$hourVal?></option>
							<?php } ?>
						</select>
						h
						<select class="event-2char" id="event-minutes" name="event-minutes">
							<option selected="selected" disabled="disabled">----</option>
							<?php
								$minVal = 0;
								for(;$minVal <= 59; $minVal++){
							?>
								<option value=<?=$minVal?>><?=$minVal?></option>
							<?php } ?>
						</select>
						m
					</div>
				</div>
				<div id="create-event-type">
					<strong>Type:</strong>
					<div id="create-event-type-dropdown">
						<select name="event-type">
							<option selected="selected" disabled="disabled">Choose Type</option>
							<?php foreach ($eventTypes as $eventType) { ?>
								<option value=<?=$eventType["id"]?>><?=$eventType["type"]?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div id="create-event-area-right">
				<div>
					<strong>Image:</strong>
					<input type="file" id="input-event-image" name="event-image" value="images/defaultImage.jpeg">
					<div id="create-event-image">
						<img id="thumbnail-event-image" src="images/defaultImage.jpeg">
					</div>
					<script>
						document.getElementById("input-event-image").onchange = function () {
							var reader = new FileReader();

							reader.onload = function (e) {
								if(e.target.result.substring(e.target.result.indexOf(':') + 1, e.target.result.indexOf(':') + 6).toLowerCase() == 'image'){
									document.getElementById("thumbnail-event-image").src = e.target.result;
									document.getElementById("input-event-image").value = e.target.result;
								}else{
									alert('ERROR! Not a valid image.');
								}
							};

							reader.readAsDataURL(this.files[0]);
						};
					</script>
				</div>
			</div>
			<div id="create-event-area-center">
				<strong>Description:</strong>
				<br>
				<textarea maxlength="500" rows="12" cols="55" name="event-description"></textarea>
			</div>
			<div id="buttons-create-event-area">
				<input id="cancelCreateEventButton" type="button" value="Cancel">
				<input id="createEventButton" type="submit" value="Create">
			</div>
			<?php if(isset($_SESSION['ERROR'])){ ?>
				<div id="create-event-error">
					<?php
						echo $_SESSION['ERROR'];
						unset($_SESSION['ERROR']);
					?>
				</div>
			<?php } ?>
		</form>
	</section>

	<?php include('footer.php'); ?>

  <!--Awesome scripts!-->
	<script>
			$("#logout").click(logout);
			$("#userNameNav").click(openMenu);
			$("#cancelCreateEventButton").click(function(){
					location.href = 'myEvents.php';
			});
	</script>
	<script src="Animations.js"> </script>
</body>
</html>
