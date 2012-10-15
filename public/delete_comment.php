<?php 


if(isset($_POST['user_id'])){
	$user_id = $user_id;
}else{
	// something
	// redirect_to("error_page.php");
}

if(isset($_POST['image_id'])){
	$delete_from = "image_comments";
	$delete_id = $_POST['image_id'];
}else{
	// something
	// redirect_to("error_page.php");
}

if(isset($_POST['profile_id'])){
	$delete_from = "profile_comments";
	$delete_id = $_POST['profile_id'];
}else{
	// something
	// redirect_to("error_page.php");
}

if(Comment::delete_comment($user_id,$delete_from,$delete_id)){
	// sucess
	echo "true";
}else{
	echo "false";
	// crap
}


?>
