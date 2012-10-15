<?php 
require_once('../includes/initialize.php');



if(!isset($_POST['image_id'])){
	echo 'No image selected!';

} elseif (!$session->is_logged_in()){
	echo 'Not logged in';

} else {

	if (isset($_POST['is_profile'])) {
		$image = User::find_by_id($_POST['image_id']);
		
	} else {

		$image = Image::find_by_id($_POST['image_id']);
	}

	if(!$image){
		
		echo "Image not found!";

	} else {

			
		if($comment = $image->add_comment($session->user_id, $_POST['comment_text'])){

			include(TEMPLATE_DIR.DS.'comment.php');

		}else{
			echo "Problem with query";
		}
	}
}

?>