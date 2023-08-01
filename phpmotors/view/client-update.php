<?php 
//if session in not true,redirect to main controller
if(!isset($_SESSION['loggedin'])){
    header('Location: /phpmotors/index.php');
}


?><!doctype html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PHP Motors Add Vehicle">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title>Update Account | PHP Motors
        </title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>

    
                <div class="addVehicle">
                    <h2>Update Account Information</h2>
                    <?php
                    if (isset($messageAcc)) { 
                        echo $messageAcc; 
                       } 
                    ?>
                    <form method="post" action="/phpmotors/accounts/index.php">
                       <fieldset>
                        <legend>Account Update</legend>
                        <label >*First Name: <input type="text" name="clientFirstname" id="clientFName" required 
                        <?php 
                        if(isset($clientFirstname)){
                            echo "value='$clientFirstname'";
                        } elseif(isset($clientInfo['clientFirstname'])) {echo "value='$clientInfo[clientFirstname]'";}  
                        ?>></label>
                        
                        <label >*Last Name: <input type="text" name="clientLastname" id="clientLName" required
                        <?php 
                        if(isset($clientLastname)){
                            echo "value='$clientLastname'";
                        } elseif(isset($clientInfo['clientLastname'])) {echo "value='$clientInfo[clientLastname]'";}  
                        ?>></label>
                        
                        <label >*E-mail: <input type="email" name="clientEmail" id="clientEmail" required placeholder="Enter a valid email address"
                        <?php 
                        if(isset($clientEmail)){
                            echo "value='$clientEmail'";
                        } elseif(isset($clientInfo['clientEmail'])) {echo "value='$clientInfo[clientEmail]'";}  
                        ?>></label>
                        
                       </fieldset>
                       <input type="submit" name="submit" value="Update Account" id="updateUser-btn">

                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="updateUserInfo">

                        <input type="hidden" name="clientId" value="
                        <?php if(isset($clientInfo['clientId'])){ echo $clientInfo['clientId'];} 
                        elseif(isset($clientId)){ echo $clientId; } ?>
                        ">
                       
                    </form>
                    <hr>
                    <h2>Update Password</h2>
                    <?php
                    if (isset($messagePass)) { 
                        echo $messagePass; 
                       } 
                    ?>
                    <form method="post" action="/phpmotors/accounts/index.php">
                       <fieldset>
                        <legend>Change Password</legend>
                        <p>Current password will change permanently</p>
                        <p class="passwordDesc">Password should have 8 characters or more and contain at least 1 number, 1 special character and 1 capital letter.</p>

                        <label >*New Password: <input type="password" name="clientPassword" id="clientPassword" minlength="8" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"></label>
                        <input type="button" onclick="showPassword()" class="showPassword" value="Show Password">

                       </fieldset>
                       <input type="submit" name="submit" value="Update Password" id="updatePassw-btn">

                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="updatePassword">

                        <input type="hidden" name="clientId" value="
                        <?php if(isset($clientInfo['clientId'])){ echo $clientInfo['clientId'];} 
                        elseif(isset($clientId)){ echo $clientId; } ?>
                        ">
                       
                    </form>
                </div>

            </main>
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
            <script>
                function showPassword(){
                let password = document.getElementById("clientPassword");
                password.type === "password"? password.type = "text" : password.type = "password";
                
                }
         </script>
        </div>  <!--wrapper ends-->
        </body>
    </html>