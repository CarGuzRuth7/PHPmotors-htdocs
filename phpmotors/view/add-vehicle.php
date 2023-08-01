<?php 
//if session in not true,redirect to main controller
if(!isset($_SESSION['loggedin'])){
    header('Location: /phpmotors/index.php');
}
if($_SESSION['clientData']['clientLevel'] < 2){
    header('Location: /phpmotors/index.php');
    exit;
}

//get classification list (dropdown select menu)
    $classificationList =  '<label>Choose a car Classification:</label>
                            <select id="classificationId" name="classificationName" required>
                            <option>Choose a classification</option>';

    foreach($classifications as $classification){
        $classificationList .=  "<option value='$classification[classificationId]'";
        if(isset($classificationId)){ 
            if($classification['classificationId'] == $classificationId){
                $classificationList .= ' selected ';

            }  
        } 
        $classificationList .= ">$classification[classificationName]</option>";  
                          
    }
    $classificationList .=  '</select>';
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
        <title>Add Vehicle | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>

    
                <div class="addVehicle">
                    <h1>Add New Car</h1>
                    <?php
                    if (isset($message)) {
                    echo $message;
                    }
                    ?>
                    
                    <form method="post" action="/phpmotors/vehicles/index.php">
                        <?php
                        echo $classificationList
                        ?>
                        <label >Make: <input type="text" name="invMake" id="make" required  <?php if(isset($invMake)){ echo "value='$invMake'";} ?> ></label>
                        <label >Model: <input type="text" name="invModel" id="model" required <?php if(isset($invModel)){ echo "value='$invModel'";} ?> ></label>            
                        <label >Description:<br> <textarea name="invDescription" id="description" required ><?php if(isset($invDescription)){ echo $invDescription;} ?></textarea></label>
                        <label >Image Path: <input type="text" name="invImage" id="imagepath" value="/phpmotors/images/no-image.png" required <?php if(isset($invImage)){ echo "value='$invImage'";} ?> ></label>
                        <label >Thumbnail Path: <input type="text" name="invThumbnail" id="thumbnailpath" value="/phpmotors/images/no-image-tn.png" required <?php if(isset($invThumbnail)){ echo "value='$invThumbnail'";} ?> ></label>
                        <label >Price: <input type="number" name="invPrice" id="price" min="0" required <?php if(isset($invPrice)){ echo "value='$invPrice'";} ?> ></label>
                        <label >Stock: <input type="number" name="invStock" id="stock" min="0" required <?php if(isset($invStock)){ echo "value='$invStock'";} ?> ></label>
                        <label >Color: <input type="text" name="invColor" id="color" required <?php if(isset($invColor)){ echo "value='$invColor'";} ?> ></label>

                        <br>
                        <input type="submit" name="submit" value="Add Vehicle" id="add-vehicle-btn">

                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="addnewvehicle">
                    </form>
                </div>

            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
            </div> <!--wrapper ends-->
        </body>
    </html>