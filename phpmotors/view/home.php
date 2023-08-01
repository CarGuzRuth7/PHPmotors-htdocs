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
        <link rel="shortcut icon" href="/phpmotors/images/site/phpmotorsfavicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/phpmotors/css/style.css" type="text/css" media="screen">
        <title>Home Page | PHP Motors</title>
    </head>
    <body>
        <div id="wrapper">
            <?php 
            //Add header template
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php';  
            ?>
            <main>
            <div class="home">
            <h1>Welcome to PHP Motors</h1>

            <div class="delorean-des">

                <p><strong>DMC Delorean</strong><br> Cup holders <br>Superman doors <br>Fuzzy dice!</p>
                <img src="images/vehicles/delorean.jpg" alt="DMC Delorean" class="delorean-img">
                <a href="/phpmotors/vehicles/?action=vehicleDetail&invId=16"><img src="images/site/own_today.png" alt="Own Today" class="own-today"></a>
            </div>

            <section class="reviews">
                <h2>DMC Delorean Reviews</h2>
                <ul>
                    <li>"So fast its almost like traveling in time." (4/5)</li>
                    <li>"Coolest ride on the road." (4/5)</li>
                    <li>"I'm feeling Marty McFly!" (5/5)</li>
                    <li>"The most futuristic ride of our day." (4.5/5)</li>
                    <li>"80's livin and I love it!" (5/5)</li>
                </ul>
            </section>
            <section class="upgrades">
                <h2>Delorean Upgrades</h2>
                <div class="upgrades-items">
                    <div>
                        <img src="images/upgrades/flux-cap.png" alt="Flux Capacitor">
                        <a href="#">Flux Capacitor</a>
                    </div>
                    <div>
                        <img src="images/upgrades/flame.jpg" alt="Flame Decals">
                        <a href="#">Flame Decals</a>
                    </div>
                    <div>
                        <img src="images/upgrades/bumper_sticker.jpg" alt="Bumper Stickers">
                        <a href="#">Bumper Stickers</a>
                    </div>
                    <div>
                        <img src="images/upgrades/hub-cap.jpg" alt="Hub Caps">
                        <a href="#">Hub Caps</a>
                    </div>
                </div>
            </section>
            </div>
            </main>
            <?php
            //Add footer template 
            require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php';
            ?>
                        </div> <!--wrapper ends-->
        </body>
    </html>