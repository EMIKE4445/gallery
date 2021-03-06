<?php
        require_once('includes/init.php');

        echo <<<EOL
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>gallery</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
        EOL;

if(!$user->is_logged()){?>

    <header class="header-bar">
        <div class="site-logo">
             <span>Gallery</span> 
        </div>
        <div class="users-no">
            <p class="users-no-p" id="users-no"></p>
        </div>
    </header>
    <div class="main-u">
        
        <div class="cta-div"><p class="cta"><span>sign-in</span> to upload and view pictures <span onclick="display_register_form()" class="register-link" id="register-link">Or register</span></p></div>
        <div class="form-div" id="form-div">    
        </div>
        
    </div>


<?php }else{?>

        <header class="header-bar">
            <div class="site-logo">
                <span>Gallery</span> 
            </div>
            <div class="user-info" id="user-info">
                <span id="username"></span>
                <span id="id">ID: <span id="id-no"></span></span>

            </div>
            <div class="view-by" id="view-by">
                <form id="view-by-form" onsubmit="event.preventDefault(); load_images()">
                    <select name="view" id="view">
                        <option value="2">All pictures</option>
                        <option value="1">My pictures</option>
                        
                    </select>
                    
                    <input type="submit" id="view-btn" value="view">
                </form>  
            </div>
            
            <div class="acc-actions">
                
                <img src="images/app_images/menu.svg" alt="menu" class="menu-ham" id="menu-ham">
                <ul class="acc-list">
                    <li><a href="#" id="upload-picture">upload picture</a></li>
                    <li><a href="#" id="change-password">change password</a></li>
                    <li><a href="#" id="delete-account">delete account</a></li>
                    <li><a href="#" id="logout">logout</a></li>
                </ul>
            </div>
            
        </header>
        <div class="slide" id="slide">
            <span class="close-text" id ="close-text" onclick='hide_slide()'>x</span>
            <span class="previous" onclick="previous_slide()"><</span>
            <div class="slide-image" id="slide-image"></div>
            <span class="next" onclick="next_slide()">></span>
        </div>
        
        <div class="main-l" id="main-l">

        </div>

<?php }

echo<<<EOF
    
        <footer class="footer">
            
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved 
            </footer>
            <script src='application.js'></script>
          
        </footer>
       
    </body>
    </html>
EOF;
?>