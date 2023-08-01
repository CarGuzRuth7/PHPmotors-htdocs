
                <header>
                    <div id="top-header">
                        <img src="/phpmotors/images/site/logo.png" alt="php motors logo" id="logo">

                        <?php 
                        if(isset($_SESSION['loggedin'])){
                            echo '<p><a href="/phpmotors/accounts/index.php?action=admin">' 
                            . $_SESSION['clientData']['clientFirstname'].'</a>'
                            .' | ' 
                            .'<a href="/phpmotors/accounts/index.php?action=logout" title="Logout Session in PHP Motors" id="acc">Log Out</a>
                            </p>';
                        }
                        else {
                            echo '<a href="/phpmotors/accounts/index.php?action=login" title="Login or Register with PHP Motors" id="acc">My Account</a>';
                        }

                        
                        ?>

                        <!-- <a href="/phpmotors/accounts/index.php?action=login" title="Login or Register with PHP Motors" id="acc">My Account</a> -->

                    </div>
                </header>
                <nav>
                    <?php 
                    //Add nav template 
                    //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/nav.php'; 
                    //call navBar to build navigation bar
                    //$navList = navBar(getClassifications());
                     echo $navList;
                    ?>
                </nav>
                