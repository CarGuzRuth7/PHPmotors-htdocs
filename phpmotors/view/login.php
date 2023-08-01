<!--Modularization-->
<!doctype html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PHP Motors Login Page">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title>Sing In | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
            <div class="login">
                    <h1>Login to Your Account</h1>

                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    ?>

                    <form method="post" action="/phpmotors/accounts/">
                        <label >E-mail: <input type="email" name="clientEmail" id="clientEmail" required placeholder="Enter a valid email address"
                        <?php 
                        if(isset($clientEmail)){
                            echo "value='$clientEmail'";}  
                        ?>></label>
                        
                        <label >Password:  <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"></label>
                        
                        <p class="passwordDesc">Password should have 8 characters or more and contain at least 1 number, 1 special character and 1 capital letter.</p>
                        <input type="button" onclick="showPassword()" class="showPassword" value="Show Password">
                        <br>
                    
                        <input type="submit" name="submit" value="Login" id="login-btn">
                        <input type="hidden" name="action" value="log-in">
                        
                        <a href="/phpmotors/accounts/index.php?action=registration" class="register-redirection">No Account? Sign-up</a>
                    </form>
            </div>
            </main> 
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
            </div> <!--wrapper ends-->
         <script>
                function showPassword(){
                let password = document.getElementById("clientPassword");
                password.type === "password"? password.type = "text" : password.type = "password";
                
                }
         </script>
        </body>
    </html>