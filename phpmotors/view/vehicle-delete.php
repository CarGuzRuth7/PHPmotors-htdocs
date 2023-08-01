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
        <meta name="description" content="PHP Motors Add Vehicle">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title><?php if(isset($invInfo['invMake'])){ 
	            echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?> | PHP Motors
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
                    <h1><?php if(isset($invInfo['invMake'])){ 
	                echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?></h1>
                    <?php
                    if (isset($message)) {
                    echo $message;
                    }
                    ?>
                    <p class="notice">Confirm Vehicle Deletion. The delete is permanent.</p>
                    <form method="post" action="/phpmotors/vehicles/index.php">
                       
                        <label >Make: <input type="text" name="invMake" id="make" readonly  <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>></label>
                        <label >Model: <input type="text" name="invModel" id="model" readonly <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; } ?> ></label>            
                        <label >Description:<br> <textarea name="invDescription" id="description" readonly ><?php if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; } ?></textarea></label>
                        <br>
                        <input type="submit" name="submit" value="Delete Vehicle" id="mod-vehicle-btn">

                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="deleteVehicle">

                        <input type="hidden" name="invId" value="

                        <?php if(isset($invInfo['invId'])){echo $invInfo['invId']; } ?>

                        ">
                    </form>
                </div>

            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
            </div> <!--wrapper ends-->
        </body>
    </html>