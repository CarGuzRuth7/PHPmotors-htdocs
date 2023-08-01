<?php
//if session in not true,redirect to main controller
if(!isset($_SESSION['loggedin'])){
    header('Location: /phpmotors/index.php');
}
if($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /phpmotors/index.php');
    exit;
}
?><!doctype html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PHP Motors Add New Classification">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title>Add New Classification | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
                <div class="addClassification">

                    <h1>Add New Car Classification</h1>
                    <?php
                    if (isset($message)) {
                    echo $message;
                    }
                    ?>
                    
                    <form method="post" action="/phpmotors/vehicles/index.php">
                        <label >Classification Name:
                        <br> <span class="description">*Classification Name should be less than 30 characters</span>
                        <input type="text" name="classificationName" id="classificationName" maxlength="30" required ></label>
                        
                        <br>           
                        <input type="submit" name="submit" value="Add Classification" id="addclass-btn">

                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="addclassification">
                    </form>
                </div>
            </main>
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
            </div> <!--wrapper ends-->
        </body>
    </html>