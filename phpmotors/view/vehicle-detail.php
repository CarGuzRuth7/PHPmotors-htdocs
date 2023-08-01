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
        <title> <?php echo $vehicle['invMake'].' '. $vehicle['invModel']; ?> | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
                <div class="view">
               
                <?php if(isset($vehicleDetail)){
                  echo $vehicleDetail;
                } ?>
                <hr>
                <h2>Customer Reviews</h2>
                <?php 
                    if(isset($_SESSION['loggedin'])){
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            }
                            
                        $clientInfo = $_SESSION['clientData'];
                        $initial = substr($clientInfo['clientFirstname'], 0, 1);

                        $r = "<p>Review the $vehicle[invMake] $vehicle[invModel]</p>";
                        $r .= '<form action="/phpmotors/reviews/" method="post">';
                        $r .= "<fieldset>";
                        $r .= "<label>Screen Name: <input type='text' name='clientFirstname' value='$initial$clientInfo[clientLastname]' readonly='readonly' required></label>";
                        $r .= "<label>Review: <textarea name='reviewText' required></textarea></label>";
                        $r .= '<input type="submit" class="regbtn" value="Submit Review">';
                        $r .= '<input type="hidden" name="action" value="addReview">';
                        $r .= "<input type='hidden' name='invId' value='$vehicle[invId]'>";
                        $r .= "<input type='hidden' name='clientId' value='$clientInfo[clientId]'>";
                        $r .= "</fieldset>";
                       
                        $r .= "</form>";
                        echo $r;
                    }
                    else {
                        echo '<p>You must ➡️ <a href="/phpmotors/accounts/index.php?action=login" title="Login with PHP Motors">Login</a> ⬅️ to write a review</p>';
                    }
                    
                ?>
                
                <?php if(isset($message)){
                  echo $message; }

                if(isset($reviews)){ //show reviews for that single vehicle
                    echo $reviews;
                }
                
                ?>
               

                </div>
            </main>
            <?php
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php';
            ?>
        </div> <!--wrapper ends-->
        </body>
    </html><?php unset($_SESSION['message']); ?>