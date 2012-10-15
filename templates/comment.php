<?php 

if(!($user = User::find_by_id($comment->user_id)))
	die("User not found");

if(!($user_image = Image::find_by_id($user->image_id)))
	die("No profile image");

?>
<div class="commenting">

	<img src="<?php echo 'images' . DS . $user_image->filename; ?>" alt="<?php echo $user_image->title ?>" />

	<div>
		<a href="profile.php?id=<?php echo $user->id ?>"><?php echo $user->username; ?></a>
		<p class="comment_text"><?php echo $comment->comment ?></p>
	</div>
</div>
