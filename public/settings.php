<?php
include('../includes/initialize.php');



if (!$session->is_logged_in()){
	redirect_to("index.php");
} else {
	$user = User::find_by_id($session->user_id);
	if(isset($_POST['submit'])) {
		


		$user->about_me = $_POST['about_me'];

		if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
			$user->image_id = Image::next_id();
			$image = Image::make($session->user_id,'avatar',$_FILES['avatar']);

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
		$user->update();
	}
	
	
	$title = "Profile settings for {$user->username} :: Infinity-gag";
	
	include(TEMPLATE_DIR.DS.'header.php');
	?>
<body>
	<?php
	include(TEMPLATE_DIR.DS.'headbar.php');
	$profile_image = Image::find_by_id($user->image_id);
	?>
	<div id="container" style="">
		<div id="main" class="middle">
			<div id="block-content">
				<div class="content-title">
					<h3>Settings</h3>
				</div>
				<div id="content">
					<form id="form-settings" class="page" action="settings.php"
						method="post" enctype="multipart/form-data">

						<div class="field profile-pic">
							<h4>Profile Pic</h4>
							<div class="wrap">
								<div class="image-wrap">
									<img id="uploaded_img" width="160px"
										src="images/<?php echo $profile_image->filename; ?>"
										alt="avatar">
								</div>
								<input class="file" type="file" name="avatar">
								<p class="info">JPEG, GIF or PNG. Max size: 2MB.</p>
							</div>
						</div>



						<hr>


						<div class="field">
							<label>
								<h4>About me</h4> <textarea style="resize: none" cols="56" rows="5" class="text tipped" name="about_me"><?php echo $user->about_me; ?></textarea>
							</label>
						</div>

						<input type="hidden" name="submit" />
	

						<input type="submit" name="Save" id="#login-submit" class="submit-button" value="Save" />


					</form>
					<!--end setting-actions-->
				</div>
			</div>
		</div>
	</div>
	<?php
	//echo output_message($message);
}
include(TEMPLATE_DIR.DS.'footer.php');

?>