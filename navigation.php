<!-- NAVIGATION BAR -->
<?php
	if(!isset($_SESSION))
	{
		session_start();
	}
?>

	<nav>
	<div id="title"> <a href="index.php"> EVENTUS </a> </div>
	<div id="loginBlock">
		<?php if(isset($_SESSION['start'])){ ?>
			<div id="userNavArea">
				<div id="userNameNav"> <img src=<?=$_SESSION["imagePath"]?> id="profileIcon" alt="profileIcon"/>
				<div id="userNameIcon"> <i class="fa fa-bars"></i> </div> </div>
				<input id="logout" type="button" value="Log Out">
			</div>
			<div id="profileTabMenu">
				Signed in as:
				<div id="userNameMenuLabel"> <?=$_SESSION['username'] ?> </div>
					<ul>
						<li><a href="index.php"> <i class="fa fa-search"></i> Search </a></li>
						<li><a href=<?="profile.php?uid=" . $_SESSION['id']?> > <i class="fa fa-user"></i> Profile </a></li>
						<li> <a href="myEvents.php"> <i class="fa fa-calendar-o"></i> My Events </a> </li>
					</ul>
				</div>
		<?php }else { ?>
			<div class="navItem"> <form id="loginForm" action="" method="post" autocomplete="on">
				<div class="label1">
				Username:
				</div>
				<input id="username" type="text" name="username" maxlength="20">
				<div class="label1">
				Password:
				</div>
				<input id="password" type="password" name="password" maxlength="20">
				<div id="errorBlock"> Valid </div>
				<input id="login" type="button" value="Log In">
			</form> </div>
	<?php	} ?>
	</div>
	</nav>
