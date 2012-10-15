<?php 

require_once('../includes/initialize.php');


if($session->is_logged_in())
	redirect_to("index.php");

if(isset($_POST['submit'])){
  //securing values coming from the user, maybe better place was inside the class User, but good for now
  $username = $database.escape_value($_POST['username']);
  $password = $database.escape_value($_POST['password']);
  
  
	if($user = User::authenticate($username, $password )){
		if($user->validate == 'true'){
			if($session->login($user)){
				redirect_to('index.php');
			}else{
				$message="Login failed!";
			}

		}
		else
    {
			$message = "User is not validated yet.";
		}
	} else {
		$message = 'Wrong username/password combination';
	}
}
else{
	$message="";
}


$title = "Login :: Infinity-gag";

include(TEMPLATE_DIR . DS . "header.php");

?>


<body id="page-signup">
	<?php include(TEMPLATE_DIR . DS . "headbar.php"); ?>

	<div class="signup-login-wrap">
		<a class="signup-login-btn" href="register.php">New to INFINITY-GAG? <b>Join
				today!</b>
		</a>
		<div class="content">
			<div class="description">
				<h2>Login, my master!</h2>
				<p class="message"></p>
			</div>


			<form id="form-signup-login" class="generic" action="login.php"
				method="post">

				<div id="login-username-block" class="field">
					<label>Username</label> <input id="login-username" type="text"
						class="text" name="username" placeholder="Username" tabindex="1"
						maxlength="200" />
				</div>


				<div id="login-password-block" class="field">
					<label>Password </label> <input id="login-password" type="password"
						class="text" name="password" placeholder="Password" tabindex="3"
						maxlength="32" />
				</div>
				<div class="action">
					<input id="login-submit" type="submit" name="submit"
						class="submit-button" value="Login" />
				</div>
				<?php echo output_message($message);  ?>

			</form>
		</div>
	</div>