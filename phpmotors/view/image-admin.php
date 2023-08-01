<?php
//if session in not true,redirect to main controller
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }

?><!doctype html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PHP Motors Admin page">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <title> Image Management | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
                <div class="view">
                    <h1>Image Management</h1>
                    <p>Welcome to the image management. Please choose one of the following options:</p>
                    <hr>
                    <h2>Add New Vehicle Image</h2>
                    <?php
                    if (isset($message)) {
                    echo $message;
                    } ?>

                    <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
                        <label>Select a Vehicle:</label>
                        <?php echo $prodSelect; ?>
                        <fieldset>
                            <label>Is this the main image for the vehicle?</label>
                            <label class="pImage">
                                Yes <input type="radio" name="imgPrimary" class="pImage" value="1">
                            </label>
                            
                            <label class="pImage">
                                No <input type="radio" name="imgPrimary"  class="pImage" checked value="0">
                            </label>
                           
                        </fieldset>
                        <label>Upload Image: <input type="file" name="file1"></label>
                        
                        <input type="submit" class="regbtn" value="Upload">
                        <input type="hidden" name="action" value="upload">
                    </form>
                    <hr>
                    <h2>Existing Images</h2>
                    <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
                    <?php
                    if (isset($imageDisplay)) {
                    echo $imageDisplay;
                    } ?>
                   
                </div>
            </main>
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
            </div> <!--wrapper ends-->
        </body>
    </html><?php unset($_SESSION['message']); ?>