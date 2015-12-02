<section id="main-area">
	<?php
		if(count($_GET) != 0){
	  $db = new PDO('sqlite:Database/data.db');

	  /* Searches for events that meet the criteria */
	  $tmp = $db->prepare('SELECT * FROM event WHERE name LIKE ? ORDER BY name');
	  $tmp->execute(array('%' . $_GET["query"] . '%'));
	  $results = $tmp->fetchAll();

		/* Get full string from query */
		$search = $_GET["query"];
		str_replace("+"," ",$search);

		?>
		<form id="search-bar-area" method="post" action="searchEvent.php">
			<input id="search-bar" name="query" type="text" value=<?php echo '"' . $search . '"';?>>
			<input id="submit-search" type="submit" value="">
			<div class="floatClear"> </div>
		</form>
		<?php foreach ($results as $result) { ?>
			<a <?='href="event.php?eid=' . $result["id"] . '"'?> class="search-event">
					<?php if($result["image"] == 1){
							echo "<img src='" . $result["imagePath"] . "'/>";
						}else if($result["image"] == 0){
							echo "<img src='images/defaultImage.jpeg'/>";
						}
						/* Get event type */
						$tmp = $db->prepare('SELECT type FROM typeOfEvent WHERE id = ?');
					  $tmp->execute(array($result["typeId"]));
					  $type = $tmp->fetch();
						?>
					<section>
						<h1><?=$result["name"]?></h1>
						<h2><?=$result["dateOfEvent"]?></h2>
						<h3>Type: <?=$type["type"]?></h3>
					</section>
			</a>
		<?php } ?>
	<?php }else{ ?>
		<form id="search-bar-area" method="post" action="searchEvent.php">
			<input id="search-bar" name="query" type="text" value="Search for events">
			<input id="submit-search" type="submit" value="">
			<div class="floatClear"> <div>
		</form>
	<?php } ?>
	<div id="space"></div>
</section>
