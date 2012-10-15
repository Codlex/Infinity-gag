<?php
require_once('../includes/initialize.php');
if( $session->is_logged_in() ){
	$session->logout();
	$message = 'You have been successfully logged out';
	redirect_to("index.php");
} else {
	$message = 'You are not logged in';
	redirect_to("index.php");
}

?>