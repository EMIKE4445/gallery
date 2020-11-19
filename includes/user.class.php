<?php
require_once('autoloader.php');
session_start();
class user extends gallery{


    public function delete_account($id){
        
        $sql="DELETE FROM users WHERE id=:ID";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['ID'=>$id]);
        
        if($result){
            if($this->delete_user_image($id)){
                
                return 1;
            }else{
                return false;
            }

           
        }else{
            
            return false;
        }
    }

    public function update_password($id,$password){
        $sql="UPDATE USERS SET user_password= :pass WHERE id=:id";
        $prep=$this->conn->prepare($sql);
        $password=password_hash($pasword,PASSWORD_DEFAULT);
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
        $hashed_password=$result['user_password'];
        
        return password_verify($password,$hashed_password)? true:false;
    }

    public function register($username,$email,$password){
       $sql="INSERT INTO USERS(username,email,user_password) VALUES(:username,:email,:upassword)";
       $prep=$this->conn->prepare($sql);
       $password=password_hash($password,PASSWORD_DEFAULT);
       $result=$prep->execute(['username'=>$username,'email'=>$email,'upassword'=>$password]);
       if($result){
           
           return true;
       }else{
           var_dump($result);
           return false;
       }
    }

    public function verify_user($username,$password){
        $sql='SELECT id,user_password FROM USERS WHERE username =:user';
        $prep=$this->conn->prepare($sql);
        
        $result=$prep->execute(['user'=>$username]);
        $result=$prep->fetch();
        $id=$result['id'];
        $hashed_password=$result['user_password'];
        if(password_verify($password,$hashed_password)){
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