<?php 



require_once('../includes/initialize.php');


if(!isset($_POST['image_id'])){
	echo 'No image selected!';
} elseif (!$session->is_logged_in()){
	echo 'Not logged in';
} else {

	$image = Image::find_by_id($_POST['image_id']);

	if(!$image){
		echo "Image not found!";
	} elseif ($image->user_voted($session->user_id)) {
		echo "Already voted!";
	} else {
			
		if($image->add_vote($session->user_id))
			echo "true";
		else
			echo "Problem with query";
	}
}


?>