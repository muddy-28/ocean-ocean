<?php

class itemClass extends database{
		
		public function exec($sql){
			if(empty($sql)){
				return mysql_error();
			}
			else{
				return mysql_query($sql);
			}
		}

		public function submit($ptitle,$description,$catagory,$image,$mainfile,$filelink){
		$sql = "insert into projects set title='$ptitle', description='$description', catagory='$catagory', image='$image', 
		mainfile='$mainfile', filelink='$filelink', user_id='".$_SESSION['user_id']."'";
		return $this->exec($sql);
		}

		public function lastID(){
			return mysql_insert_id();
		}

		public function viewall(){
			$sql="select * from projects,user where projects.user_id=user.user_id order by projects.date desc";
			return $this->exec($sql);
		}

		public function viewallmy($user_id){
			$sql="select * from projects,user where projects.user_id=user.user_id and user.user_id=$user_id order by projects.date desc";
			return $this->exec($sql);
		}

		public function viewrecent(){
			$sql="select * from projects,user where projects.user_id=user.user_id order by projects.date desc limit 0,10";
			return $this->exec($sql);
		}

		public function viewfooter(){
			$sql="select * from projects,user where projects.user_id=user.user_id order by projects.date desc limit 0,5";
			return $this->exec($sql);
		}

		public function viewpost($id){
			$sql="select * from projects,user where projects.project_id='$id'";
			return $this->exec($sql);
		}

		public function updatepost($ptitle,$description,$catagory,$image,$mainfile,$filelink,$project_id){
			$sql="update projects set title='$ptitle', description='$description', catagory='$catagory', image='$image', 
			mainfile='$mainfile', filelink='$filelink' where project_id=$project_id";
		}

		public function search($search){
			if(!isset($search)||empty($search)){
				$search='%';
			}
			$sql="select * from projects,user where projects.user_id=user.user_id AND (projects.catagory like '$search%' OR 
				projects.title like '%$search%' OR projects.description like '%$search%' OR user.firstname like '%$search%' OR 
				user.lastname like '%$search%')";
			return $this->exec($sql);
		}

		public function setcomment($user,$id,$comment){
			$sql="INSERT INTO `project`.`comment` (`comment_id`, `comment`, `catagory`, `project_id`, `user_id`) VALUES (NULL, '$comment', 'pakistan', $id, $user)";
			return $this->exec($sql);
		}

		function viewcomment($p_id){
			$sql="SELECT * FROM `comment` WHERE project_id=$p_id";
			return $this->exec($sql);
		}

		public function deletepost($projectid){
			$sql = "delete from projects where project_id=$projectid";
			return $this->exec($sql);
		}
} //end of itemClass

$item = new itemClass();

?>