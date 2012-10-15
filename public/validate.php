<?php require_once('../includes/initialize.php'); ?>

<?php


if(isset($_GET['id']))
	$id=$_GET['id'];
else{
	$message= "Wrong parameters.";
}
if(isset($_GET['validate']))
	$validate=$_GET['validate'];
else{
	$message.= "Wrong parameters.";
}

$message = "";

if(User::user_validate($id,$validate)){
	$message = "User is sucessfully validate.";
}
else{
	$message = "There was an error validating the user.";
}

$title = "Validation page :: Infinity-gag";
include(TEMPLATE_DIR.DS.'header.php');

?>

<body id="page-signup">
<?php include(TEMPLATE_DIR.DS.'headbar.php')?>

	<div class="signup-login-wrap">
		<a class="signup-login-btn" href="register.php">New to INFINITY-GAG? <b>Join
				today!</b>
		</a>
		<div class="content">
			<div class="description">
				<h2>Validation page</h2>
				<?php echo $message;?>
			</div>
		</div>
	</div>

</body>
</html>
