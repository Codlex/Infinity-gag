<?php 
include("../includes/initialize.php");



if(isset($_GET['id']))
	$image = Image::find_by_id($_GET['id']);

if(isset($_GET['delete']) && isset($_GET['id']) ){

	$image_id = $_GET['id'];

	if(Image::delete_image($image_id)){
		redirect_to("index.php");
	} else {
		$message = "Could not delete image!";
	}

}

$title = "Image {$image->title} :: Infinity-gag";

include(TEMPLATE_DIR . DS . "header.php");
?>

<body>

	<?php include(TEMPLATE_DIR . DS . "headbar.php"); ?>
	<div id="container" style="">
		<?php 
		
		?>
		<div id="main">

			<div id="block-content">
				<div class="post-info-pad">
					<h1>
						<?php echo $image->title; ?>
					</h1>
					<p>
						<?php $user = User::find_by_id($image->user_id); ?>
						<a href="profile.php?id=<?php echo $user->id ?>"><?php echo $user->username ?>
						</a> <span class="seperator">|</span>
						<?php $image->print_time(); ?>

						<span class="comment"><?php echo $image->count_comments(); ?> </span>
						<span class="loved"><?php echo $image->count_votes(); ?> </span>

					</p>
					<ul class="actions">
						<?php
						if($session->is_logged_in()){

							if( !$image->user_voted($session->user_id)){
								echo "<li> <a class=\"love\" href=\"#\">Love</a></li>";
							} else {
								echo "<li> <a class=\"love-current\" href=\"#\">Unlove</a></li>";
							}

						}

						?>
						<?php						
						if($session->is_logged_in() && ($image->user_id == $session->user_id)){
							echo '<li><a class="deletea" href="image.php?id=' . $image->id .'&delete=1">Delete</a></li>';
						}


						?>

					</ul>

				</div>
				<!--end post-info-pad-->


				<div id="content">
					<div class="post-container">
						<div class="img-wrap">


							<img src="images/<?php echo $image->filename; ?>"
								alt="<?php $image->title; ?>" style="max-width: 700px;" />



						</div>
						<!--end image-wrap-->
					</div>
					<!--end post-container-->

					<div class="comment-section">
						<h3 class="title" id="comments">Comments</h3>


						<?php

						if($session->is_logged_in())
						{

							?>
						<form class="commenting" id="comentaraa" method="post">
							<input type="hidden" value="<?php echo $_GET['id']; ?>"
								name="image_id" />
							<?php 

							if(!($user = User::find_by_id($session->user_id)))
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
						$comments = ImageComment::find_all_by_id($_GET['id']);
							
						foreach($comments as $comment){

							include(TEMPLATE_DIR.DS."comment.php");

						}
							
						?>
						
						</div>

					</div>
					<!--end div.comment-section-->
					<br />


				</div>


			</div>
			<!--end div.block-content-->


		</div>
		<!--end div#main-->
		<?php include(TEMPLATE_DIR.DS."sidebar.php"); ?>
	</div>
</body>


</html>
