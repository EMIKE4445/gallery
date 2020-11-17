<?php

if(isset($_GET['form'])){
    $form=$_GET['form'];
    switch($form){
        case('login'):{
            echo<<<eol
             <form class="login" id="login-form" onsubmit="event.preventDefault(); log_user_in()">
                <label for="username">username:</label><br><input name="username" type="text" placeholder="username.." id="username" ><br>
                <label for="password">password:</label><br><input type="password" name="password" placeholder="password.." id="password"><br>
                <input type="submit" value="login" id="login-btn">
             </form>
             eol;
             break;

        }
        case('register'):{
            echo<<<eol
            <form class="register" id="register-form" onsubmit="event.preventDefault(); register_user()">
                <label for="username">username:</label><br><input name="username" id="username" type="text" placeholder="username.."><br>
                <label for="email">email:</label><br><input type="email" name="email" id="email" placeholder="email.." ><br>
                <label for="password">password</label><br><input type="password" name="password" id="password" placeholder="password.."><br>
                <label for="confirm_password">confirm password:</label><br><input type="password" name="confirm_password" id="confirm-password" placeholder="confirm password"><br>
                <label for="remember_me">remember me <input type="radio" name="remember_me"></label><br>
                <input type="submit" value="register" id="register-btn">
            </form>
            eol;
            break;
        }
        case('image_upload'):{
            echo<<<eol
            <form class="image-upload" id="upload-image-form" onsubmit="event.preventDefault(); upload_image()" >
                <label for="picture_name">picture name:</label><input type="text" name="picture_name" placeholder="picture name.." id="picture-name">
                <label for="picture">picture:</label><input type="file" name="picture" id="file">
               
                <input type="submit" value="upload" id="upload">
           </form>
           eol;
           break;

        }
        default:{
            echo "in switch but no catch";
        }
    
    }
}else{
    exit;
}