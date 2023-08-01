<!--Modularization-->
<!doctype html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PHP Motors registration page">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title>Register | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
            <div class="registration">
                    <h1>Create A New Account</h1>

                    <?php
                    if (isset($message)) {
                    echo $message;
                    }
                    ?>
                    
                    <form method="post" action="/phpmotors/accounts/index.php">
                        <label >*First Name: <input type="text" name="clientFirstname" id="clientFName" required 
                        <?php 
                        if(isset($clientFirstname)){
                            echo "value='$clientFirstname'";}  
                        ?>></label>
                        
                        <label >*Last Name: <input type="text" name="clientLastname" id="clientLName" required
                        <?php 
                        if(isset($clientLastname)){
                            echo "value='$clientLastname'";}  
                        ?>></label>
                        
                        <label >*E-mail: <input type="email" name="clientEmail" id="clientEmail" required placeholder="Enter a valid email address"
                        <?php 
                        if(isset($clientEmail)){
                            echo "value='$clientEmail'";}  
                        ?>></label>
                        
                        <label >*Create Password: <input type="password" name="clientPassword" id="clientPassword" minlength="8" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"></label>
                        
                        <p class="passwordDesc">Password should have 8 characters or more and contain at least 1 number, 1 special character and 1 capital letter.</p>
                        <input type="button" onclick="showPassword()" class="showPassword" value="Show Password">
                        <br>
                        <input type="submit" name="submit" value="Register" id="register-btn">

                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="register">
                    </form>

                    
            </div>
            </main>
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
        </div>
         <script>
                function showPassword(){
                let password = document.getElementById("clientPassword");
                password.type === "password"? password.type = "text" : password.type = "password";
                
                }
         </script>
         
        </body>
    </html>
