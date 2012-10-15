<?php 

require_once('../includes/initialize.php');


$max_file_size = 1048576;  // 1MB
$message = "";

if(!$session->is_logged_in())
	redirect_to("login.php");

if(isset($_POST['submit'])) {
	$image = Image::make($session->user_id,$_POST['title'],$_FILES['file_upload']);

	if(!$image) {
		$message = "Creating image error.";
	}
	else
	{

		if($image->save())
		{
			$message = "Image uploaded successfully";
		}else {
			$message =  join("<br />",$image->errors);
		}
	}
}

$title = "Upload image :: Infinity-gag";

include(TEMPLATE_DIR . DS . "header.php");

?>



<body id="page-signup">
	<?php include(TEMPLATE_DIR.DS.'headbar.php')?>
	<div class="signup-login-wrap">

		<div class="content">
			<div class="description">
				<h2>Upload image, my master!</h2>
				<p class="message"></p>
			</div>

			<form id="form-signup-login" enctype="multipart/form-data"
				class="generic" action="upload.php" method="post">

				<div id="login-username-block" class="field">
					<label>Image title: </label> <input id="login-username" type="text"
						class="text" name="title" value="" />
				</div>


				<div id="login-password-block" class="field">
					<label>Select file to upload: </label> <input type="file"
						name="file_upload" />
				</div>

				<div class="action">
					<input id="login-submit" type="submit" name="submit"
						class="submit-button" value="Upload" />
				</div>
				<?php echo output_message($message);  ?>

			</form>
		</div>
	</div>





	<?php include(TEMPLATE_DIR.DS."footer.php"); ?>