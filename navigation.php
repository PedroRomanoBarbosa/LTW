<?php session_start();
			echo '<div id="nav">';
			include('header.php');
			echo '<div id="loginBlock">';
			if(isset($_SESSION['start'])){
				echo '<img src="images/iconTemplate.png" id="profileIcon" alt="profileIcon"/>';
				echo $_SESSION['username'];
				echo '<a href="createEvent"> <div class="navItem">  Create an event </div> </a>';
				echo '<div class="navItem"> <input id="logout" type="button" value="Log Out"> </div>';
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
			if(isset($_SESSION['start'])){

			}else {
				echo '<div id="promoArea">
								<div id="promoInfo">
									<div id="space"> </div>
									<div id="promoTitle"> CREATE, DISCOVER AND JOIN  </div>
									<div id="promoSubTitle"> - The best event organizer you will ever experience - </div>
									<div id="promoText"> EVENTUS is a platform that enables users to create, discover and join all sorts of events all over the world! </div>
									<input type="button" id="reg" value="JOIN NOW!"/>
								</div>
							</div>';
				echo '<div id="registerArea">
									<div id="registerFormArea"></div>
							</div>';
			}
?>
