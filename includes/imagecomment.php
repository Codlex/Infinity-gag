<?php 
require_once('initialize.php');

class ImageComment extends Comment{
	protected static $db_fields = array('id','user_id', 'image_id','comment');
	public static $table_name = "image_comments";
	public static $criteria = "image_id";

}


?>