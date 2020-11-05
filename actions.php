<?php
require_once('includes/init.php');
session_start();

//determine request type
if ( $_SERVER["REQUEST_METHOD"] == "POST" ){

    if(array_key_exists('action',$_POST)){
        //functions to handle post request
        //test if user is logged because only logged users cn post to app
        if($user->is_logged()){
            $action=$_post['action'];

            switch($action){
                case('insert_image'):{
                    //code to insert image
                    if(isset($_POST['picture'])){
                        $user_id=$_SESSION['logged_user'];
                        $img_name=$_POST['picture_name'];
                        
                
                        $img_tmp=$_FILES['picture']['tmp_name'];
                        $img_size=$_FILES['picture']['size'];
                       
                        $img_type=$_FILES['picture']['type'];
                
                            //@$img_ex=strtolower(end(explode('.',$_FILES['picture']['name'])));
                            $allowed_ex=array('jpeg','jpg','png');
                            if(in_array($img_type,$allowed_ex)===FALSE){$error_m[]='file extension not allowed';}
                            if($img_size>2097152){$error_m[]='file too big';}
                            if(empty($error_m)){
                                $move=move_uploaded_file($img_tmp,'images/uploaded_images/'.$img_name);
                                if ($move){
                                    $added_file=$user->insert_image($img_name,$user_id);
                                    if($added_file){
                                        echo "added file sucessfully";
                                    }else{
                                        echo 'could not add to database';
                                    }
                                  
                                }
                            
                            }else{
                                echo json_encode($error_m);
                            }
                
                    }else{
                        header('location:index.php');
                    }
                    
                     
                    break;
                }
               
                case('register'):{
                    if(isset($_POST['register'])){
                        $username=$_POST['username'];
                        $email=$_POST['email'];
                        $password=$_POST['password'];
                 
                        $registered=$user->register($username,$email,$password);
                        if($registerd){
                            echo "registerd sucessfully";
                        }else{
                            echo "could not register";
                        }
                    }else{
                        echo json_encode('invalid request');
                    }
                    break;
                }
                case('update_password'):{
                    $id=$_POST['id'];
                    $old_pass=$_POST['old_pass'];
                    $new_pass=$_post['new_pass'];
                    $confirm_pass=$_POST['cpass'];

                   
                        if($id==$_SESSION['id']){
                            if($new_pass=$confirm_pass){
                                if($user->confirm_user_password($id,$old_pass)){
                                    if($user->update_password($id,$password)){
                                        echo json_encode('password updated');
                                    }else{
                                        echo json_encode('could not udate password');
                                    }
                                }else{
                                    echo json_encode('incorect password');
                                }
                            }else{
                                echo json_encode('passwords do not match');
                            }
                            
                            
                        }else{
                            echo json_encode('invalid request');
                        }
                    
                 break;
                }
                case('delete_account'):{
                    $user_id=$_post['id'];
                    //check if id is same as logged user
                    if($user_id==$_SESSION['logged_user']){
                        if($user->delete_account($id)){
                            echo json_encode('account deleted');
                        }else{
                            echo json_encode('could not delete ccount');
                        }
                    }else{
                        echo json_encode('coul not delete account');
                    }
                   
                    break;
                }
                case('delete_picture'):{
                    $pic_id=$_post['picture_id'];
                    $same_user=($user->get_image_user($id))==($_SESSION['logged_user'])? true :false;
                    if($same_user){
                        if($user->delete_image($id)){
                            echo json_encode('image deleted');
                        }else{
                            echo json_encode('could not delete image');
                        }
                    }else{
                        echo json_encode('could not delete image');
                    }
                }
                case('log_in'):{
                    $user_id=$_post['id'];
                    $password=$_post['password'];
                    if($user->confirm_user($id,$password)){
                        $_SESSION['logged_user']=$id;
                        echo json_encode('success');
                    }else{
                        echo json_encode('user details not correct');
                    } 
                    break;   
                }
                
            }

        }else{
            exit;
        }

    }else{
        echo json_encode('invalid request');
    }

}elseif( $_SERVER["REQUEST_METHOD"] == "GET"){
    if(array_key_exists('request',$_GET)){
        //functions to handle get request
        $request=$_GET['request'];
        switch($request){
            case('get_user_image'):{
                //move this to get
                $user_id=$_GET['id'];
                $results=$user->get_image_by_id($user_id);
                echo $results? $results: json_encode('could not get images');
                break;
                
            }
            case('get_all_images'):{
                $results=$user->get_all_images();
                echo json_encode('$results');
            }


        }

    }else{
        echo json_encode('invalid request');
    }



}else{
    exit;
}









?>