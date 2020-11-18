<?php
require_once('autoloader.php');
session_start();
class user extends gallery{


    public function delete_account($id){
        $sql="DELETE * FROM USERS WHERE ID=:ID";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['ID'=>$id]);
        if($result){
            if($this->delete_user_image($id)){
                echo "account deleted";
                return 1;
            }else{
                echo "could not delete user images";
            }

           
        }else{
            echo "could not delete account";
            return false;
        }
    }

    public function update_password($id,$password){
        $sql="UPDATE USERS SET user_password= :pass WHERE id=:id";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['pass'=>$password,'id'=>$id]);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function confirm_user_password($id,$password){
        $sql="SELECT user_password from users where id=:id";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['id'=>$id]);
        $result=$prep->fetch();
        
        return $result['user_password']==$password? true:false;
    }

    public function register($username,$email,$password){
       $sql="INSERT INTO USERS(username,email,user_password) VALUES(:username,:email,:upassword)";
       $prep=$this->conn->prepare($sql);
       $result=$prep->execute(['username'=>$username,'email'=>$email,'upassword'=>$password]);
       if($result){
           
           return true;
       }else{
           var_dump($result);
           return false;
       }
    }

    public function verify_user($username,$password){
        $sql='SELECT id FROM USERS WHERE username =:user AND user_password=:pass';
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['user'=>$username,'pass'=>$password]);
        $id=$prep->fetch();
        $id=$id['id'];
        if($result){
            return $id;
        }else{
            return false;
        }
    }
    
    public function is_logged(){
        if(isset($_SESSION['id'])){
            // echo "is logged";
            return true;
        }else{
            // echo 'is not logged';
            var_dump($_SESSION);
            return false;
        }
    
    }

    public function get_user_details($id){
        $sql='SELECT id,username FROM USERS WHERE id=:id';
        $prep=$this->conn->prepare($sql);
        
        $prep->execute(['id'=>$id]);
        $user=$prep->fetch();
        return $user;
    }

}
?>