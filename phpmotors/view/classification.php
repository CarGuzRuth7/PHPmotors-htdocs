<!doctype html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PHP Motors template">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title><?php echo $classificationName; ?> vehicles | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
                <div class="view">
                <h1><?php echo $classificationName; ?> vehicles</h1>
                <br>
                <?php if(isset($message)){
                  echo $message; }
                ?>
                <?php if(isset($vehicleDisplay)){
                  echo $vehicleDisplay;
                } ?>
               

                </div>
            </main>
            <?php
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php';
            ?>
        </div> <!--wrapper ends-->
        </body>
    </html>