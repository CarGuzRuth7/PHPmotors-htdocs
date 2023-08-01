<?php
//if session in not true,redirect to main controller
if(!isset($_SESSION['loggedin'])){
    header('Location: /phpmotors/index.php');
}
$clientInfo = $_SESSION['clientData'];

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
        <title><?php echo $clientInfo['clientFirstname'] ?> | Profile | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
                <div class="view">
                    <h1 id="user-name"><?php echo $clientInfo['clientFirstname'] .' ' . $clientInfo['clientLastname'] ?></h1>
                    <?php
                    if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    }
                    ?>
                    <p>You are logged in.</p>
                    <ul>
                        <li>First Name: <?php echo $clientInfo['clientFirstname']; ?></li>
                        <li>Last Name: <?php echo $clientInfo['clientLastname']; ?></li>
                        <li>Email: <?php echo $clientInfo['clientEmail']; ?></li>
                        
                    </ul>
                    <section class="inv-mangmt">
                        <h2>Account Management</h2>
                        <p>Use this link to update account information</p>
                        <?php 
                        if($clientInfo['clientId']){
                             $updAcc = '<p><a href="../accounts/index.php?action=updateAccount&clientId='.$clientInfo['clientId'].'">👤 Update Account Information</a></p>';
                             echo $updAcc;
                        }
                        ?>
                        
                    </section>
                    
                    <noscript>
                    <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
                    </noscript>
                        <?php 
                        if($clientInfo['clientLevel'] > 1){
                            
                            $management = '<section class="inv-mangmt"><h2>Inventory Management</h2>
                            <p>Use this link to manage the inventory</p>
                            <p><a href="../vehicles/index.php">🏁 Vehicles Management</a></p>
                            </section>';

                            $imgMgnt = '<section class="inv-mangmt"><h2>Image Management</h2>
                            <p>Use this link to manage the inventory images</p>
                            <p><a href="../uploads/index.php">🖼️ Images Management</a></p>
                            </section>';

                            echo $management;
                            echo $imgMgnt;
                        }
                        ?>
                    
                        <?php
                        $r = "<section id='review-list' data-userId='$clientInfo[clientId]'>";
                        $r .= '<h2>Manage Your Product Reviews</h2>';
                        $r .= '</section>';
                       // echo $r;
                        if(isset($r)){ //show reviews for that single vehicle
                            echo $r;
                         }
                         else{echo "You don't have reviews yet";}
                       
                      //  ?>
       
                    
        
                    
                </div>
            </main>
            <?php 
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; 
            ?>
            </div> <!--wrapper ends-->
            <script src="../js/reviews.js"></script>
        </body>
    </html><?php unset($_SESSION['message']); ?>