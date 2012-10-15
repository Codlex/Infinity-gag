<?php 
require_once('initialize.php');

class ProfileComment extends Comment{
	protected static $db_fields = array('id','user_id', 'profile_id','comment');
	public static $table_name = "profile_comments";
	public static $criteria = "profile_id";

}


?>