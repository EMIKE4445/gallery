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
            <span>users number should be here</span>
        </div>
    </header>
    <div class="main-u">
        <div class="form-div">    
        </div>
    </div>


<?php }else{?>

        <header class="header-bar">
            <div class="site-logo">
                <span>Gallery</span> 
            </div>
            <div class="view-by" id="view-by">
                <form>
                    <select name="view" id="view">
                        <option value="my pictures">My pictures</option>
                        <option value="all pictures">All pictures</option>
                    </select>
                    <button id="view-btn">view</button>
                </form>  
            </div>

            <div class="acc-actions">
                <span class="account">account</span>
                <ul class="acc-list">
                    <li id='chpass'>change password</li>
                    <li id='delacc'>delete account</li>
                </ul>
            </div>

        </header>

        <div class="main-l">

        </div>

<?php }

echo<<<EOF
    
        <footer>
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved 
        </footer>
        <script src="application.js"></script>
    </body>
    </html>
EOF;
?>