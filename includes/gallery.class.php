<?php
 require_once('autoloader.php');


class gallery extends database{

    private $conn;


    public function __construct(){
      $this->conn=$this->connect();
    }

    public function get_all_images(){
       $sql="SELECT * FROM IMAGES" ;
       $prep=$this->conn->prepare($sql);
       $result=$prep->execute();
       $reult=$result->fetchAll();
       return $result;
    }
    
    public function get_image_by_id($id){
        $sql="SELECT * FROM IMAGES WHERE USER_ID = :user";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['user'=>$id]);
        $result=$result->fetchAll();
        return $result;
    }

    public function insert_image($image_name,$user_id){
        $sql="INSERT INTO IMAGES (image_name,user_id) VALUES(:img_name,:user)";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['img_name'=>$image_name,'user'=>$user_id]);
        if($result){
           // echo 'added sucessfully';
            return 1;
        }else{
            echo 'could not add image';
            return false;
        }
    }

    public function delete_image($image_id){
        $sql ="DELETE * FROM IMAGES WHERE image_id=:id ";
        $prep= $this->conn->prepare($sql);
        $result=$prep->execute(['id'=>$image_id]);
        return $result? true:false;
    }

    public function get_image_user($image_id){
        $sql="SELECT user_id from images where id=:image_id";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['image_id'=>$image_id]);
        $result=$result->fetch();
        return $result;
    }


    public function delete_user_image($user_id){
        $sql ="DELETE * FROM IMAGES WHERE user_id=:id ";
        $prep= $this->conn->prepare($sql);
        $result=$prep->execute(['id'=>$user_id]);
        if($result){
           return true;
        }else{
            return false;
        }
    }

    static public function total_number_of_users(){
        $sql="SELECT COUNT FROM USERS";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute();
        $result=$result->fetchAll();
        return $result;
    }
 }


?>