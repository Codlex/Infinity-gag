<?php

require_once('initialize.php');

class Comment extends DatabaseObject{
	 
	 
	 
	public $id;
	public $user_id;
	public $comment;

	 
	 
	public static function find_all_by_id($id){

		$sql = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE " . static::$criteria . " = {$id}";
		$sql .=" ORDER BY id DESC";

		return static::find_by_sql($sql);
	}
	 
	 
	 
	 
	public static function delete_comment($user_id, $delete_from, $delete_id){
		global $database;
		if($delete_from == 'profile_comments'){
			$name_id = 'profile_id';
		}

		if($delete_from == 'image_comments'){
			$name_id = 'image_id';
		}

		$sql = "SELECT * FROM ".$delete_from;
		$sql.=" WHERE user_id =". $database->escape_value($user_id);
		$sql.=" AND ".$name_id."=".$database->escape_value($delete_id);
		$sql.=" LIMIT 1";

		if($comment = self::find_by_sql($sql)){
			$comment[0]->add_to = $delete_from;
			$comment[0]->delete();
			return true;
		}
		else{
			// failed to find comment
		}

	}
	 
	 
	public function delete(){
		global $database;
			
		$sql = "DELETE FROM ".$this->add_to;
		$sql.= " WHERE id=". $database->escape_value($this->id);
		$sql.= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	 

	 
	 
	 
}
?>