<?php
include('../includes/initialize.php');



if(isset($_GET['id'])){
	if(!($user_selected = User::find_by_id($_GET['id']))){
		$user_selected_id = 1; //default

		$message = "User doesn't exist";
	}

}

$title = "User {$user_selected->username} :: Infinity-gag";

include(TEMPLATE_DIR.DS.'header.php');


if (isset($user_selected)) {

	$profile_image = Image::find_by_id($user_selected->image_id);



	?>
<body>

	<?php include(TEMPLATE_DIR.DS.'headbar.php');?>
	<div id="container" style="">
		<div id="main">
			<div id="block-content">
				<div class="profile-pad">
					<div class="profile-image">
						<a href="profile.php?id=<?php echo $user_selected->id; ?>"> <img
							src="images/<?php echo $profile_image->filename; ?>"
							alt="Profile Pic">
						</a>
					</div>
					<div class="profile-info" href="#">
						<h3>
							<a href="profile.php?id=<?php echo $user_selected->id ?>"><?php echo $user_selected->username; ?>
							</a>
						</h3>

						<h4>Date of birth:</h4>
						<p>
							<?php echo $user_selected->date; ?>
						</p>


						<h4>About me:</h4>
						<?php if ($user_selected->about_me == '') { ?>
						<p>You have not yet entered anything about yourself. Care to
							share? We won't abuse the info.</p>
						<?php } else { ?>
						<p>
							<?php echo $user_selected->about_me; ?>
						</p>
						<?php } ?>


						<?php 

						if($session->is_logged_in() && $_GET['id'] == $session->user_id){
							echo '<a class="settings" href="settings.php">Settings</a>';
						}
						?>


					</div>
				</div>





				<div class="filter-bar with-topping">
					<ul class="content-type">


						<li><a
						<?php if(!isset($_GET['comments'])) echo 'class="current"'; ?>
							href="profile.php?id=<?php echo $user_selected->id ?>"> <strong>Posts</strong>
						</a>
						</li>

						<li><a
						<?php if(isset($_GET['comments'])) echo 'class="current"'; ?>
							href="profile.php?comments=1&id=<?php echo $user_selected->id ?>"><strong>Comments</strong>
						</a></li>

					</ul>


				</div>



				<div id="content">
					<input type="hidden" id="suggest-tags" value="">
					<div id="entry-list" class="list">
						<ul id="entry-list-ul" class="col-1">


							<?php 
							if(isset($_GET['comments'])){
								if($session->is_logged_in())
								{

									?>
							<form class="commenting" id="comentaraa" method="post">
								<input type="hidden" value="1" name="is_profile" /> <input
									type="hidden" value="<?php echo $_GET['id']; ?>"
									name="image_id" />
								<?php 

								if(!($user = User::find_by_id($user_selected->id)))
									die("User not found");

								if(!($user_image = Image::find_by_id($user->image_id)))
									die("No profile image");

								?>
								<img style="max_width: 250px; max_height: 250px;"
									src="<?php echo 'images' . DS . $user_image->filename; ?>"
									alt="<?php echo $user_image->title ?>" />

								<div>
									<p>
										<a href="profile.php?id=<?php echo $user->id ?>"> <?php echo $user->username; ?></a>
									</p>
									<textarea name="comment_text" id="comment_text" value=""></textarea>
									<input type="button" value="Send comment" id="comentara" />
								</div>


							</form>
							<hr />
							<div id="comment_container">
														
														<?php 
								}else{
									echo "<p class=\"comment_text\">Login to comment!</p>";
								}

								?>
														<?php 
														$comments = ProfileComment::find_all_by_id($_GET['id']);
															
														foreach($comments as $comment){

															include(TEMPLATE_DIR.DS."comment.php");

														}
															

							} else {
									
								$images = Image::all_images_from_user_ordered_by_date($user_selected->id);
							foreach($images as $image){ ?>
							
							<li class=" entry-item">

								<div class="content">
									<div class="img-wrap">
										<a href="image.php?id=<?php echo $image->id; ?>" target="_blank" class="">
											<img src="images/<?php echo $image->filename; ?>" alt="<?php echo $image->title ?>" style="max-width: 460px;" />
										</a>
										
									</div>
									<div class="fatbigdick all-users-expand"></div>

								</div> <!--end div.content-->

								<div class="info jump_stop jump_focus ">
									<div class="sticky-items  " id="sticky-item-4324602" style="">
										<h1>
											<a href="image.php?id=<?php echo $image->id; ?>" target="_blank" class=""><?php echo $image->title ?></a>
										</h1>
										<h4 class="all-users-expand">
											<?php 
											$user_selected = User::find_by_id($image->user_id);
											?>
											<a href="profile.php?id=<?php echo $user_selected->id; ?>"	target="_blank"><?php echo $user_selected->username ?></a>
											<p>
												<?php $image->print_time(); ?>
											</p>
										</h4>



									</div>

								</div> <!--end div.info-->
							</li>
   				<?php } 
}?>

						
						</ul>
					</div>
					<!--end entry-list-->



				</div>
				<!--end content-->

			</div>
		</div>
	</div>
	<?php
}
//echo output_message($message);


include(TEMPLATE_DIR.DS.'sidebar.php');
include(TEMPLATE_DIR.DS.'footer.php');

?>