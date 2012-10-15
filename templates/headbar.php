
<div id="headbar-wrap">
	<div id="head-bar">
		<h1>
			<a class="logo" href="index.php">INFINITY-GAG</a>
		</h1>

		<ul class="main-menu" style="overflow: visible">
			<li><a class="add-post" href="upload.php">Upload</a>
			</li>
		</ul>

		<ul class="main-2-menu">


			<?php
			if($session->is_logged_in()){
					
				$user = User::find_by_id($session->user_id);
					
				echo "<li><a class=\"button\" href=\"profile.php?id={$user->id}\">{$user->username}</a></li>";
				echo "<li><a class=\"button\" href=\"logout.php\">Logout</a></li>";

			} else {

				?>

			<li id="headbar-signup-button" class="toggle-enabled"
				style="display: block;"><a class="signup-button red"
				href="register.php">Y U No Signup?!</a>
			</li>
			<li><a href="login.php" class="button">Login</a>
			</li>

			<?php } ?>
		</ul>
	</div>
	<!--end div#head-bar -->
</div>
<!--end headbar-wrap-->
