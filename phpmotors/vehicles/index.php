<?php
//VEHICLES CONTROLLER

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
// Get the functions library
require_once '../library/functions.php';

require_once '../model/uploads-model.php';
require_once '../model/reviews-model.php';


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
    case 'newClassification':
      include '../view/add-classification.php';
    break;
    case 'newVehicle':
      include '../view/add-vehicle.php';
    break;
    case 'addclassification':
      // Filter and store the data
      $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

      // Check for missing data
      if( empty($classificationName)){
        $message = '<p class="emptyField">Please provide information for all empty form fields.</p>';
        include '../view/add-classification.php';
        exit; 
      }

      // Send the data to the model
      $regOutcome = addClassification($classificationName);

      // Check and report the result
      if($regOutcome === 1){
        // $message = "<p>$classificationName classification has been added.</p>";
       // include '../view/vehicle-management.php';
        // exit;
        header('Location: ../vehicles/index.php');
       // header("cache-control: no cache"); // forces vehicle-management to reload
        exit;
      } else {
        $message = "<p class='emptyField'>Something went wrong and the creation of $classificationName classification failed. Please try again.</p>";
        include '../view/add-classification.php';
        exit;
      }
    break;

    case 'addnewvehicle':
        // Filter and store the data
      $classificationId = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_NUMBER_INT));
      $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
      $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
      $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
      // Check for missing data
      if(empty($classificationId) || 
      empty($invMake) || 
      empty($invModel) || 
      empty($invDescription) || 
      empty($invImage) || 
      empty($invThumbnail) || 
      empty($invPrice) || 
      empty($invStock) || 
      empty($invColor)
      ) {
        $message = '<p class="emptyField">Please provide information for all empty form fields.</p>';
        include '../view/add-vehicle.php';
        exit; 
      }

      // Send the data to the model
      $regOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

      // Check and report the result
      if($regOutcome === 1) {
        $message = "<p class='success'>$invMake $invModel was successfully added to the inventory.</p>";
        include '../view/add-vehicle.php';
        exit;

      } else {
        $message = "<p class='emptyField'>Something went wrong and the creation of $invMake $invModel failed. Please try again.</p>";
        include '../view/add-vehicle.php';
        exit;
      }

    break;

    /* * ********************************** 
    * Get vehicles by classificationId 
    * Used for starting Update & Delete process 
    * ********************************** */ 
    case 'getInventoryItems': 
      // Get the classificationId 
      $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
      // Fetch the vehicles by classificationId from the DB 
      $inventoryArray = getInventoryByClassification($classificationId); 
      // Convert the array to a JSON object and send it back (we use echo statement)
      echo json_encode($inventoryArray); 
    break;
    case 'mod':
      //capture the value of the second name - value pair
      $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
      //get the information for that single vehicle
      $invInfo = getInvItemInfo($invId);
      //if it has no data, diplay message
      if(count($invInfo)<1){
       $message = 'Sorry, no vehicle information could be found.';
      }
      //calle view to modify vehicle
      include '../view/vehicle-update.php';
      exit;

    break;
    case 'updateVehicle':
          // Filter and store the data
          $classificationId = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_NUMBER_INT));
          $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
          $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
          $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
          $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

          // Check for missing data
          if(empty($classificationId) || 
          empty($invMake) || 
          empty($invModel) || 
          empty($invDescription) || 
          empty($invImage) || 
          empty($invThumbnail) || 
          empty($invPrice) || 
          empty($invStock) || 
          empty($invColor)
          ) {
            $message = '<p class="emptyField">Please provide information for all empty form fields.</p>';
            include '../view/vehicle-update.php';
            exit; 
          }
    
          // Send the data to the model
          $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
    
          // Check and report the result
          if($updateResult) {
            $message = "<p class='success'>Congratulations, the $invMake $invModel was successfully updated.</p>";
	          $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
    
          } else {
            $message = "<p class='emptyField'>Error. The vehicle was not updated.</p>";
	          include '../view/vehicle-update.php';
            exit;
          }

    break;
    case 'del':
      //capture the value of the second name - value pair
      $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
      //get the information for that single vehicle
      $invInfo = getInvItemInfo($invId);
      //if it has no data, diplay message
      if(count($invInfo)<1){
       $message = 'Sorry, no vehicle information could be found.';
      }
      //calle view to modify vehicle
      include '../view/vehicle-delete.php';
      exit;

    break;
    case 'deleteVehicle':
        // Filter and store the data
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
  
        // Send the data to the model
        $deleteResult = deleteVehicle($invId);
  
        // Check and report the result
        if($deleteResult) {
          $message = "<p class='success'>Congratulations, the $invMake $invModel was successfully deleted.</p>";
          $_SESSION['message'] = $message;
          header('location: /phpmotors/vehicles/');
          exit;
  
        } else {
          $message = "<p class='emptyField'>Error. The vehicle was not deleted.</p>";
          $_SESSION['message'] = $message;
        	header('location: /phpmotors/vehicles/');
          exit;
        }
						
    break;
    case 'classification':
      //get name-value pair from navList
      $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $vehicles = getVehiclesByClassification($classificationName);
      if(!count($vehicles)){
       $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
      } else {
       $vehicleDisplay = buildVehiclesDisplay($vehicles);
      }
      include '../view/classification.php';
    break;
    case 'vehicleDetail':
      //get name-value pair from navList
      $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
      //get the information for that single vehicle
      $vehicle = getVehicleInfo($invId);
      //get rhumbnails of that vehicle
      $thumbnail = getThumbnails($invId);
      //get reviews of that vehicle
      $review = getReviewbyInventory($invId);
    //  echo '<pre>' . print_r($review, true) . '</pre>';
      
      if(!count($vehicle)){
       $message = "<p class='notice'>Sorry, no vehicle could be found.</p>";
      } else {
       $vehicleThumbnail = displayThumbnails($thumbnail);
       $vehicleDetail = buildVehiclesDetails($vehicle, $vehicleThumbnail);
      
      }

      if(!count($review)){
        $message = "<p class='notice'>Be the first to write a review.</p>";
      }else{
        $reviews = buildReviewList($review);
      }
      include '../view/vehicle-detail.php';
    break;
    default:      
      $classificationList = buildClassificationList($classifications);
        //deliver vehicle management if there is no name-value pair
        include '../view/vehicle-management.php';  
    break;
}
