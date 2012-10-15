<?php
/*
 * General functions file
*/

function redirect_to($location = NULL){
	if ( $location != NULL){
		header("Location: {$location}");
		exit;
	}
}

function output_message($message = ""){
	if( !empty($message)){
		return "<p class=\"message red\"> {$message} </p>";
	} else {
		return "";
	}
}

function __autoload($class_name){
	$class_name = strtolower($class_name);
	$path = LIB_PATH.DS."{$class_name}.php";
	if(file_exists($path)){
		require_once($path);
	} else {
		die("This file {$class_name}.php could not be found.");
	}
}

function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str="";

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}