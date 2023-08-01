<?php
//if session in not true,redirect to main controller
if(!isset($_SESSION['loggedin'])){
    header('Location: /phpmotors/index.php');
    
}
if($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /phpmotors/index.php');
    exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

?><!doctype html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PHP Motors Vechile Management">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title>Vehicle Management | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
                <div class="vehicle-management">
                    <h1>Vehicle Management</h1>
                    <a href="/phpmotors/vehicles/index.php?action=newClassification" title="Add new car classification to PHP Motors" id="newclass">🏁 Add New Car Classification</a>
                    <a href="/phpmotors/vehicles/index.php?action=newVehicle" title="Add new car to PHP Motors inventory" id="newcar">🏁 Add New Car</a>
                

                <?php
                    if (isset($message)) { 
                     echo $message; 
                    } 
                    if (isset($classificationList)) { 
                     echo '<h2>Vehicles By Classification</h2>'; 
                     echo '<p>Choose a classification to see those vehicles</p>'; 
                     echo $classificationList; 
                    }
                ?>
                <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
                </noscript>

                <table id="inventoryDisplay"></table>
                </div>
            </main>        
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
        </div> <!--wrapper ends-->
        <script src="../js/inventory.js"></script>
        </body>
    </html><?php unset($_SESSION['message']); ?>
