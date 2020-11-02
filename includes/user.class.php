<?php
require_once('autoloader.php');

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
        $sql="UPDATE USERS SET user_password= :pass WHERE ID=:ID";
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['pass'=>$password,'ID'=>$id]);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function register($username,$email,$password){
       $sql="INSERT INTO USERS(username,email,user_password) VALUES(:username,:email,:Upassword)";
       $prep=$this->conn->prepare($sql);
       $result=$prep->execute(['username'=>$username,'email'=>$email,'user_password'=>$password]);
       if($result){
           return true;
       }else{
           return false;
       }
    }

    public function verify_user($username,$password){
        $sql='SELECT id FROM USERS WHERE username =:user AND user_password=:pass';
        $prep=$this->conn->prepare($sql);
        $result=$prep->execute(['user'=>$username,'pass'=>$password]);
        $result=$result->fetch();
        if($result){
            return $result;
        }else{
            return false;
        }
    }
    
    function is_logged(){
        if(isset($_SESSION['logged_user'])){
            echo "is logged";
            return true;
        }else{
            echo 'is not logged';
            return false;
        }
    
    }

}
?>