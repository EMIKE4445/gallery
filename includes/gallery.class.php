<?php
 require_once('autoloader.php');


class gallery extends database{

    protected $conn;


    public function __construct(){
      $this->conn=$this->connect();
    }

    public function get_all_images(){
       $sql="SELECT i.*, u.username FROM IMAGES i JOIN USERS u ON i.user_id =u.id" ;
       $prep=$this->conn->prepare($sql);
       $prep->execute();
       $result=$prep->fetchAll();
       return $result;
    }
    
    public function get_image_by_id($id){
        $sql="SELECT * FROM IMAGES WHERE user_id = :user";
        $prep=$this->conn->prepare($sql);
        $prep->execute(['user'=>$id]);
        $result=$prep->fetchAll();
        return $result;
    }

    public function insert_image($image_name,$user_id){
        $sql="INSERT INTO IMAGES (image_name,user_id) VALUES(:img_name,:user)";
        $prep=$this->conn->prepare($sql);
        return $prep->execute(['img_name'=>$image_name,'user'=>$user_id])? true : false;
        
    }

    public function delete_image($image_id){
        $sql ="DELETE  FROM IMAGES WHERE image_id=:id ";
        $prep= $this->conn->prepare($sql);
        return $prep->execute(['id'=>$image_id])? true:false;
        
    }

    public function get_image_user($image_id){
        $sql="SELECT user_id from images where id=:image_id";
        $prep=$this->conn->prepare($sql);
        $prep->execute(['image_id'=>$image_id]);
        $result=$prep->fetch();
        return $result;
    }


    public function delete_user_image($user_id){
        $sql ="DELETE  FROM IMAGES WHERE user_id=:id ";
        $prep= $this->conn->prepare($sql);
        return $prep->execute(['id'=>$user_id])? true: false;
    
    }

    public function total_number_of_users(){
        $sql="SELECT COUNT(*) as num FROM users";
        $prep=$this->conn->prepare($sql);
        $prep->execute();
        $result=$prep->fetchAll();
        $result=$result[0];
        return $result;
    }
 }


?>