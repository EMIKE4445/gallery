<?php
require_once('includes/init.php');
//session_start();

//determine request type
if ( $_SERVER["REQUEST_METHOD"] == "POST" ){

    if(array_key_exists('action',$_POST)){
        //functions to handle post request

        if($_POST['action']=='register'){
           
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];
     
            $registered=$user->register($username,$email,$password);
            if($registered){
                $id=$user->verify_user($username,$password);
                $_SESSION['id']=$id;

                echo json_encode("registered successfully");
                
            }else{
                echo json_encode("could not register");
                
            }
            exit;
       
        }

        if($_POST['action']=='login'){
           
            $username=$_POST['username'];
            $password=$_POST['password'];

            $id=$user->verify_user($username,$password);


            if($id){
                $_SESSION['id']=$id;
                echo json_encode('success');
            }else{
                echo json_encode('user details not correct');
            } 
            exit;
        }

        //test if user is logged because only logged users cn post to app
        if($user->is_logged()){
           
            $action=$_POST['action'];
            switch($action){
                case('update_password'):{
                    $id=$_POST['id'];
                    $old_pass=$_POST['old_pass'];
                    $new_pass=$_POST['new_pass'];
                    $confirm_pass=$_POST['cpass'];

                   
                        if($id==$_SESSION['id']){
                            if($new_pass=$confirm_pass){
                                if($user->confirm_user_password($id,$old_pass)){
                                    if($user->update_password($id,$new_pass)){
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
                    $user_id=$_POST['id'];
                    //check if id is same as logged user
                    if($user_id==$_SESSION['id']){
                        if($user->delete_account($user_id)){
                            unset($_SESSION['logged_user']);
                            session_destroy();
                            echo json_encode('account deleted');

                        }else{
                            echo json_encode('could not delete ccount');
                        }
                    }else{
                        echo json_encode('could not delete account');
                    }
                   
                    break;
                }

                case('delete_picture'):{
                    $pic_id=$_post['picture_id'];
                    $same_user=($user->get_image_user($id))==($_SESSION['id'])? true :false;
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

                case('insert_image'):{
        
                    //code to insert image
                    if(isset($_POST['picture_name'])){
                        $user_id=$_SESSION['id'];
                        $img_name=$_POST['picture_name'];
                        
                
                        $img_tmp=$_FILES['picture']['tmp_name'];
                        $img_size=$_FILES['picture']['size'];
              
                        $img_type=$_FILES['picture']['type'];
                        @$img_type=strtolower(end(explode('/',$img_type)));
                        //echo $img_type;
                        //echo $img_size;
                            
                            $allowed_ex=array('jpeg','jpg','png');
                            if(in_array($img_type,$allowed_ex)===FALSE){$error_m[]='file extension not allowed';}
                            if($img_size>2097152){$error_m[]='file too big';}
                            if(empty($error_m)){
                                $move=move_uploaded_file($img_tmp,'images/uploaded_images/'.$img_name.'.'.$img_type);
                                if ($move){
                                    
                                    $added_file=$user->insert_image($img_name.'.'.$img_type,$user_id);
                                    if($added_file){
                                        //var_dump($added_file);
                                        echo json_encode("added file sucessfully") ;
                                    }else{
                                        echo json_encode('could not add to database');
                                    }
                                  
                                }
                            
                            }else{
                                echo json_encode($error_m);
                            }
                
                    }else{
                        echo json_encode('invalid request no image');
                    }
                    
                     
                    break;
                }

                case('logout'):{
                    unset($_SESSION['logged_user']);
                    session_destroy();
                    echo json_encode('you have been logged out');
                    
                    
                    break;
                }
                
                
            }

        }else{
            exit;
        }

    }else{
         echo json_encode('invalid request no action');
        
    }

}elseif( $_SERVER["REQUEST_METHOD"] == "GET"){
    if(array_key_exists('request',$_GET)){
        //functions to handle get request
        $request=$_GET['request'];
        switch($request){
            case('get_user_image'):{
            
                $user_id=$_GET['id'];
                $results=$user->get_image_by_id($user_id);
                echo json_encode($results);
                break;
                
            }
            case('get_all_images'):{
                $results=$user->get_all_images();
                echo json_encode($results);
                //var_dump($results);
                break;
            }
            case('get_users_no'):{
                $users_no=$user->total_number_of_users();
                //$users_no=$users_no['count(*)'];
                  echo json_encode($users_no['num']);
               //var_dump($users_no);
                break;
            }
            case('get_user_details'):{
                $id=$_SESSION['id'];
                $user=$user->get_user_details($id);
                echo json_encode($user);
                
                break;
            }


        }

    }else{
        echo json_encode('invalid request');
    }



}else{
    exit;
}









?>