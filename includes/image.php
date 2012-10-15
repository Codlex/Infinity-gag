<?php

require_once(LIB_PATH.DS.'database.php');

class Image extends DatabaseObject{

	protected static $table_name = "images";
	protected static $db_fields = array('id','user_id','title','filename','votes','date');
	public $id;
	public $user_id;
	public $title;
	public $filename;
	//<<<<<<< .mine
	public $vote;
	public $dates;
	//=======
	public $votes;
	public $date;
	public $exists;
	//>>>>>>> .r28

	private $temp_path;
	protected $upload_dir="images";
	public $errors = array();

	static function make($user_id,$title,$file){
		$image = new Image();
			
		$image->id = $image->next_id();
		$image->user_id = $user_id;
		$image->set_title($title);
		$image->attach_file($file);
		$image->votes = 0;
		$image->date = strftime("%Y-%m-%d %H:%M:%S",time());
			
		return $image;
	}

	static function all_images_ordered_by_date(){

		$sql  = "SELECT * FROM images ";
		$sql .= "ORDER BY date DESC ";
			
		return static::find_by_sql($sql);
	}

	static function all_images_ordered_by_vote(){

		$sql  = "SELECT * FROM images ";
		$sql .= "ORDER BY votes DESC ";
			
		return static::find_by_sql($sql);
	}

	static function all_images_from_user_ordered_by_date($userid){

		$sql  = "SELECT * FROM images ";
		$sql .= "WHERE user_id=".$userid." ";
		$sql .= "ORDER BY date DESC ";
			
		return static::find_by_sql($sql);
	}

	protected $upload_errors = array(
			//all upload error messsages
			UPLOAD_ERR_OK          => "No errors.",
			UPLOAD_ERR_INI_SIZE    => "Larger than upload_max filesize.",
			UPLOAD_ERR_FORM_SIZE   => "Larger than form MAX_FILE_SIZE.",
			UPLOAD_ERR_PARTIAL	   => "Partial upload.",
			UPLOAD_ERR_NO_FILE     => "No file.",
			UPLOAD_ERR_NO_TMP_DIR  => "No temporary directory.",
			UPLOAD_ERR_CANT_WRITE  => "Can't write to disk.",
			UPLOAD_ERR_EXTENSION   => "File upload stopped by extension."
	);

	public function attach_file($file){
			
		if(!$file || empty($file) || !is_array($file)){
			$this->errors[] = "No file was uploaded.";
			return false;
		}elseif($file['error'] != 0){
			$this->error[] = $this->upload_errors[$file['error']];
			return false;
		}
		else{
			$this->temp_path = $file['tmp_name'];
				
			$this->filename =  $this->id ."-".basename(str_replace(' ','-',(trim($this->title)))) . strrchr($file['name'], ".");
			return true;
		}
	}

	public function save(){
			
		if($this->exists){
			$this->update();
		}else{
			if(!empty($this->errors)) {
				return false;
			}
			if(strlen($this->title) >= 50){
				$this->errors[] = "The title can only be 50 characters lon.";
				return false;
			}
				
			if(empty($this->filename) || empty($this->temp_path)){
				$this->errors[] = "The file location was not available.";
				return false;
			}

			$target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;

			if(file_exists($target_path)){
				$this->errors[] = "The file {$this->filename} already exists.";
				return false;
			}

			if(move_uploaded_file($this->temp_path, $target_path)){
				if($this->create()){

					unset($this->tmp_path);
					return true;
				}
			}
			else{
				$this->errors[] = "The file upload failed, possibly due
				to incorrect permissions on the upload folder.";
			}
		}
	}


	public function set_title($title){
		global $database;
			
		$this->title = $database->escape_value($title);
	}

	public function print_time(){
		echo strftime("%d.%m.%Y at %H:%M", strtotime($this->date));
	}

	public function count_votes(){
		global $database;
			
		$sql  = "SELECT image_id FROM votes";
		$sql .= " WHERE image_id = {$this->id}";
			
		$result_set = $database->query($sql);
			
		$result = $database->num_rows($result_set);
			
		return $result;
	}

	public function count_comments(){
		global $database;

		$sql  = "SELECT image_id FROM image_comments";
		$sql .= " WHERE image_id = {$this->id}";

		$result_set = $database->query($sql);

		$result = $database->num_rows($result_set);

		return $result;
	}

	function user_voted($user_id){
		global $database;

		$sql  = "SELECT * FROM votes";
		$sql .= " WHERE image_id = {$this->id}";
		$sql .= " AND user_id = {$user_id}";
		$sql .= " LIMIT 1";
			
			
		$result_set = $database->fetch_array($database->query($sql));
		return !empty($result_set);
	}

	public function add_vote($user_id){
		global $database;
			
		$this->votes++;
		$this->update();

		$sql ="INSERT INTO votes (";
		$sql.= "user_id, image_id";
		$sql.= ") VALUES (";
		$sql.= "'".$user_id."','".$this->id."')";
	  
		if($database->query($sql))
			return true;
		else
			return false;
	}

	public function delete_vote($user_id){
		global $database;

		$this->votes--;
		$this->update();
			
		$sql ="DELETE FROM votes";
		$sql.= " WHERE user_id = {$user_id}";
		$sql.= " AND image_id = {$this->id}";

		if($database->query($sql))
			return true;
		else
			return false;

	}

	public static function delete_image($image_id){
			
		if($image = self::find_by_id($image_id)){
			$image->delete();
			if(unlink(SITE_ROOT.DS."public".DS."images".DS."{$image->filename}")){
				return true;
			}
			else{
				return false;
			}
		}
		else return false;
	}

	function add_comment($user_id, $comment_text){
			
		$comment = new ImageComment();
			
		$comment->user_id = $user_id;
		$comment->image_id = $this->id;
		$comment->comment = $comment_text;
			
		if(!$comment->save())
			return false;
			
		return $comment;
			
	}

}



?>