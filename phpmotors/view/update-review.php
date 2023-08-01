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
        <title>Update <?php if(isset($reviews['invMake']) && isset($reviews['invModel'])){
        echo " $reviews[invMake]  $reviews[invModel]" ;
        } elseif(isset($invMake) && isset($invModel)) { 
            echo " $invMake $invModel"; }
        ?> Review | PHP Motors
        </title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>

    
                <div class="view">
                    <h2>Edit <?php if(isset($reviews['invMake']) && isset($reviews['invModel'])){ 
                            echo "$reviews[invMake] $reviews[invModel]"; 
                    } elseif(isset($invMake) && isset($invModel)) { 
                            echo "$invMake $invModel"; }
                    ?> Review</h2>
                    <?php
                    if (isset($message)) { 
                        echo $message; 
                       } 
                       

                    ?>
                    <p>Reviewed on <?php 
                    if(isset($reviews['reviewDate'])){
                        $date = date("j F, o",strtotime($reviews['reviewDate'])); 
                         echo $date;
                    } elseif(isset($reviewDate)){
                        $date = date("j F, o",strtotime($reviewDate)); 
                         echo $date;
                    }
                    ?>.</p>
                    <form method="post" action="/phpmotors/reviews/index.php">
                       <fieldset>
                        <legend>Change Review</legend>

                        <label >New review: <textarea name='reviewText' required><?php if(isset($reviewText)){ echo $reviewText;} elseif(isset($reviews['reviewText'])) {echo "$reviews[reviewText]"; } ?></textarea></label>
                       </fieldset>
                       <input type="submit" name="submit" value="Update Review" id="updatePassw-btn">

                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="updateReview">

                        <input type="hidden" name="reviewId" value="
                        <?php if(isset($reviews['reviewId'])){ echo $reviews['reviewId'];} 
                        elseif(isset($reviewId)){ echo $reviewId; } ?>
                        ">
                       
                    </form>
                </div>

            </main>
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
        </div>  <!--wrapper ends-->
        </body>
    </html>