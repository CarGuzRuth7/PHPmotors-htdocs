<?php
//ACCOUNTS CONTROLLER

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';


// Get the array of classifications
$classifications = getClassifications();
//call navBar to build navigation bar
$navList = navBar($classifications);


//get action method
$action = filter_input( INPUT_POST, 'action' );
if ( $action == NULL ) {
  $action = filter_input( INPUT_GET, 'action' );
} 

//check for existance of firstname cookie
if(isset($_COOKIE["firstname"])){
  $_SESSION['cookieFirstname'] = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ( $action ) {
    case 'login':
      include '../view/login.php';
    break;
    case 'registration':
      include '../view/registration.php';
    break;
    case 'adminview':
      include '../view/admin.php';
    break;
    case 'register':
      // Filter and store the data
      $clientFirstname = trim( filter_input( INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS ));
      $clientLastname = trim( filter_input( INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS ));
      $clientEmail = trim( filter_input( INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL ));
      $clientPassword = trim( filter_input( INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS ));

      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);
      
      //checking for an existing email address
      $checkMatchEmail = checkExistingEmail($clientEmail);
      if($checkMatchEmail === 1){
        $message = '<p class="notice">The email address you entered already exists. Do you want to Sign In instead?</p>';
        include '../view/login.php';
        exit;

      }

      // Check for missing data
      if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
        $message = '<p class="emptyField">Please provide information for all empty form fields.</p>';
        include '../view/registration.php';
        exit; 
      }

      // Hash the checked password
      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

      // Send the data to the model
      $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

      // Check and report the result
      if($regOutcome === 1){
        setcookie("firstname", $clientFirstname, strtotime("+1 year"), "/");

        $_SESSION['message'] = "<p class='success'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
        //include '../view/login.php';
        header('Location: /phpmotors/accounts/?action=login');
        exit;
      } else {
        $message = "<p class='emptyField'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
        include '../view/registration.php';
        exit;
      }
    break;
    case 'log-in':
    
      $clientEmail = trim( filter_input( INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL ));
      $clientPassword = trim( filter_input( INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS ));

      $clientEmail = checkEmail($clientEmail);
      $checkPassword = checkPassword($clientPassword);
      
      // Check for missing data
      if( empty($clientEmail) || empty($checkPassword)){
        $message = '<p class="emptyField">Please provide information for all empty form fields.</p>';
        include '../view/login.php';
        exit; 
      }

      // A valid password exists, proceed with the login process
      // Query the client data based on the email address
      $clientData = getClient($clientEmail);
      // Compare the password just submitted against
      // the hashed password for the matching client
      $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
      // If the hashes don't match create an error
      // and return to the login view
      if(!$hashCheck) {
        $message = '<p class="notice">Please check your password and try again.</p>';
        include '../view/login.php';
        exit;
      }
      // A valid user exists, log them in
      $_SESSION['loggedin'] = TRUE;
      // Remove the password from the array
      // the array_pop function removes the last
      // element from an array
      array_pop($clientData);
      // Store the array into the session
      $_SESSION['clientData'] = $clientData;


      // Send them to the admin view
      include '../view/admin.php';
      exit;
       
    break;
    case 'logout':
      //unset session
      session_unset();
      //destroy session
      session_destroy();
      //return to phpmotors main controller
      header('Location: /phpmotors/index.php');
      exit;
    break;

    /* * ********************************** 
    * Get user by clientId 
    * Used for starting Update process 
    * ********************************** */ 
    case 'updateAccount':
       //capture the value of the second name - value pair
       $clientId = filter_input(INPUT_GET, 'clientId', FILTER_VALIDATE_INT);
       //get the information for that single vehicle
       $clientInfo = getClientInfo($clientId);
       //called view to modify information
       include '../view/client-update.php';
       exit;
    break;
    case 'updateUserInfo':
       // Filter and store the data
       $clientFirstname = trim( filter_input( INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS ));
       $clientLastname = trim( filter_input( INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS ));
       $clientEmail = trim( filter_input( INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL ));
       $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

       $clientEmail = checkEmail($clientEmail);
       $checkMatchEmail = checkExistingEmail($clientEmail);

        // Check for missing data
       if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
        $messageAcc = '<p class="emptyField">Please provide information for all empty form fields.</p>';
        include '../view/client-update.php';
        exit; 
        }
      
       //checking for an existing email address and /if email is not same as session email
        if($checkMatchEmail === 1 && $clientEmail != $_SESSION['clientData']['clientEmail']){
            $message = '<p class="notice">The email address you entered already exists.</p>';
            $_SESSION['messageAcc'] = $message;
            include '../view/client-update.php';
            exit;
          
        }      

      $updateResult = accountUpdate($clientFirstname, $clientLastname, $clientEmail, $clientId);   
      
      //  Check and report the result
       if($updateResult) {
        $message = "<p class='success'>The update was successfully.</p>";
        $_SESSION['message'] = $message;    
        $clientData = getClientInfo($clientId);
        // Remove the password from the array
       // the array_pop function removes the last
       // element from an array
        array_pop($clientData);
       // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        header('Location: /phpmotors/accounts/');
        exit;
       } else {
        $messageAcc = "<p class='emptyField'>Error. The account was not updated.</p>";
        include '../view/client-update.php';
        exit;
       }
      
    break;
    case 'updatePassword':
      $clientPassword = trim( filter_input( INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS ));
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

      $checkPassword = checkPassword($clientPassword);

      // Check for missing data
      if(empty($clientPassword)){
        $messagePass = '<p class="emptyField">Please provide information for all empty form fields.</p>';
        include '../view/client-update.php';
        exit; 
      }
      if(!$checkPassword){
        $messagePass = '<p class="emptyField">The password you entered is not a valid format.</p>';
        include '../view/client-update.php';
        exit;
      }
      
      $clientInfo = getClientInfo($clientId);
      // // Compare the password just submitted against
      // // the hashed password for the matching client
      $hashCheck = password_verify($clientPassword, $clientInfo['clientPassword']);
      // // If the hashes match create display message
      // // and return to the client-update view
      if($hashCheck) {
        $messagePass = '<p class="notice">You entered the same password. No changes were made.</p>';
        include '../view/client-update.php';
        exit;
      }
       
     // Hash the checked password
      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

      $updateResult = passwordUpdate($hashedPassword, $clientId);

      // Check and report the result
      if($updateResult) {
        $message = "<p class='success'>The update was successfully.</p>";
        $_SESSION['message'] = $message;
        header('Location: /phpmotors/accounts/');
        exit;
    
      } else {
        $messagePass = "<p class='emptyField'>Error. The password was not updated.</p>";
        include '../view/client-update.php';
        exit;
      }
    break;
    
    default:
    
    include '../view/admin.php';
      
    break;
}
