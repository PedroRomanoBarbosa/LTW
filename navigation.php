<!-- NAVIGATION BAR -->
<?php session_start();
			echo '<div id="nav">';
			echo '<div id="title"> <a href="index.php"> EVENTUS </a> </div>';
			echo '<div id="loginBlock">';
				if(isset($_SESSION['start'])){
					echo '<div id="userNavArea">';
						echo '<div id="userNameNav"> <img src="images/iconTemplate.png" id="profileIcon" alt="profileIcon"/> ';
						echo '<div id="userNameIcon"> <i class="fa fa-bars"></i> </div> </div>';
						echo '<input id="logout" type="button" value="Log Out">';
					echo '</div>';
					echo '<div id="profileTabMenu">
									Signed in as:
									<div id="userNameMenuLabel">'. $_SESSION['username'] . '</div>
									<ul>
										<li><a href="index.php"> Dashboard </a></li>
										<li><a href="myEvents.php"> Profile </a></li>
										<li> <a href="myEvents.php"> My Events </a> </li>
									</ul>
								</div>';
				}else {
					echo '
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
					</form> </div>';
				}
			echo '</div>';
			echo '</div>';
?>
