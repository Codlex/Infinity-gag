<?php

require_once(LIB_PATH.DS.'initialize.php');

class User extends DatabaseObject{
	protected static $table_name = "users";
	protected static $db_fields = array('id','username','password','email','date','about_me',
			'image_id','validate'); //validate is not necessary
	public $id;
	public $username;
	public $password;
	public $email;
	public $date;
	public $about_me;
	public $image_id;
	public $validate;
	 

	function __construct($user="",$pw="",$email="",$birthday=""){
		$this->username = $user;
		$this->password = $pw;
		$this->email = $email;
		$this->date = $birthday;
		$this->about_me = "I am new infinity-user!";
		$this->image_id = 1;
	}



	public static function authenticate($username="", $password=""){
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);

		$sql = "SELECT * FROM users ";
		$sql .= "WHERE username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);

		return !empty($result_array) ? array_shift($result_array) : false;

	}



	public static function user_exists($username){
		$sql = "SELECT username FROM ".self::$table_name;
		$sql.= " WHERE username = '{$username}'";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? true : false;
	}

	public static function user_validate($id,$validation_key){
		$sql = "SELECT * FROM ".self::$table_name;
		$sql.= " WHERE id = '{$id}'";
		$sql.= " AND validate = '{$validation_key}'";

		if(!$user = self::find_by_sql($sql)){
			return false;
		}
		else{
			$user[0]->validate = "true";
			$user[0]->update();
			return true;
		}
	}


	function add_comment($user_id, $comment_text){

		$comment = new ProfileComment();

		$comment->user_id = $user_id;
		$comment->profile_id = $this->id;
		$comment->comment = $comment_text;

		if(!$comment->save())
			return false;

		return $comment;

	}



}