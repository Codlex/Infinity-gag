<?php 

require_once('../includes/initialize.php');

$title = "Registration :: Infinity-gag";

include(TEMPLATE_DIR . DS . 'header.php');

?>

<?php

if(isset($_POST['submit'])){
	if(!checkdate($_POST['month'],$_POST['day'],$_POST['year'])){
		$message="Invalid date.";
	}
	elseif( !strlen($_POST['username']) || !strlen($_POST['password']) ) {
		$message = "You must enter a username/password.";
	}
	elseif(User::user_exists($_POST['username'])){
		$message = "Username already exists.";
	}
	elseif(empty($_POST['e-mail']))
	{
		$message = "E-mail is not optional, please enter it!";
	}
	else
	{
		$validation = rand_string(20);

		$date= $_POST['day'].".".$_POST['month'].".".$_POST['year'].".";
		$user = new User($_POST['username'],$_POST['password'],$_POST['e-mail'],$date);

		$user->validate = $validation;
		

		$to = $user->email;
		$subject = 'the subject';
		$body = "Here is link for validation of your account on infinity gag \n";
		$body .= "http://www.codlex.com/infinity-gag/public/validate.php?id=" . User::next_id() . "&validate={$validation}";
		$headers = 'From: infinity-gag@codlex.com' . "\r\n" .
				'Reply-To: infinity-gag@codlex.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
		
		
		$mailed = mail($to, $subject, $body, $headers);
		
		
		if($user->create() && $mailed){
			$message="Registration completed, please check your mail to validate your account.";
		}
		else 
		{
			$message = "Sendig mail failed!";
		}
	}
}
else{
	$message="";
}

?>

<body id="page-signup">
	<?php include(TEMPLATE_DIR . DS . "headbar.php"); ?>

	<div class="signup-login-wrap">
		<div class="content">
			<div class="description">
				<h2>Register page</h2>
				<p class="message"></p>
			</div>


			<form id="form-signup-login" class="generic" action="register.php"
				method="post">
				<?php echo $message?>
				<div id="login-block" class="field">
					<label>Username</label> <input id="login-username" type="text"
						class="text" name="username" placeholder="Username" tabindex="1"
						maxlength="200" />
				</div>


				<div id="password-block" class="field">
					<label>Password </label> <input id="login-password" type="password"
						class="text" name="password" placeholder="Password" tabindex="3"
						maxlength="32" />
				</div>

				<div id="email-block" class="field">
					<label>E-mail </label> <input id="login-email" type="text"
						class="text" name="e-mail" placeholder="e-mail" tabindex="3"
						maxlength="32" />
				</div>

				<div id="date-block" class="field">
					<label>Date of birth</label> <select name="day">
						<?php

						for($i=1;$i<=31;$i++)
						{
							echo '<option value='.$i.'>'.$i.'</option>';
						}
						?>
					</select> <select name="month">
						<?php
						$months = array("January","February","March","April","May","June","July",
								"August","September","October","November","December");
						$i=1;
						foreach($months as $month => $value){

							echo '<option value='.$i.'>'.$value.'</option>';
							$i++;
						}

						?>
					</select> <select name="year">
						<?php
						for($i=1920;$i<=2020;$i++)
						{
							echo '<option value='.$i.'>'.$i.'</option>';
						}

							
						?>

					</select>
				</div>

				<div class="action">
					<input id="login-submit" type="submit" name="submit"
						class="submit-button" value="Register" />
				</div>

				<p id="login-msg" class="message red" style="display: none;"></p>
			</form>
		</div>
	</div>
	<?php include(TEMPLATE_DIR.DS.'footer.php'); ?>