<?php
//REVIEWS CONTROLLER

// Create or access a Session
session_start();
//get database connection and models
require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../model/uploads-model.php';
require_once '../library/functions.php';
require_once '../model/reviews-model.php';


// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = navBar($classifications);

//get action method
$action = filter_input( INPUT_POST, 'action' );
if ( $action == NULL ) {
  $action = filter_input( INPUT_GET, 'action' );
} 

switch ( $action ) {
    case 'addReview':
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        if(empty($reviewText)){
            $message = '<p class="emptyField">Please provide information for all empty fields.</p>';
            $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=vehicleDetail&invId='$invId'");
            exit;
        }

        $result = addNewReview($reviewText, $invId, $clientId);
        if($result === 1) {
            $message = "<p class='success'>The review was added.</p>";
            $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=vehicleDetail&invId=$invId");
            exit;

        } else {
            $message = "<p class='emptyField'>Something went wrong and the post review failed. Please try again.</p>";
            $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=vehicleDetail&invId=$invId");
            exit;
        }

    break;

    case 'getReviews':
        $clientId = filter_input(INPUT_GET, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientReviewsArray = getReviewbyClient($clientId);
        echo json_encode($clientReviewsArray); 
    break;

    case 'editReview':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
        $reviews = getReview($reviewId);
        if(count($reviews)<1){
            $message = 'Sorry, no reviews could be found for this vehicle.';
            //$_SESSION['message'] = $message;  
           }

        include '../view/update-review.php';
        exit;
    break;

    case 'updateReview':
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));

        if(empty($reviewText)){
            $message = '<p class="emptyField">Please provide information for all empty fields.</p>';
            $reviews = getReview($reviewId);
            include '../view/update-review.php';
            exit;
        }

        $updateResult = updateReview($reviewId ,$reviewText);

         // Check and report the result
         if($updateResult) {
            $message = "<p class='success'>Congratulations, the review was successfully updated.</p>";
	          $_SESSION['message'] = $message;
            header('location: /phpmotors/reviews/');
            exit;
    
          } else {
            $message = "<p class='emptyField'>Error. The review was not updated.</p>";
            $reviews = getReview($reviewId);
            include '../view/update-review.php';
            exit;
          }

     
    break;

    case 'confirmDelete':
        $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
        $reviews = getReview($reviewId);
        if(count($reviews)<1){
            $message = 'Sorry, no reviews could be found for this vehicle.';
            
           }
           $date = date("j F, o",strtotime($reviews['reviewDate']));
        include '../view/delete-review.php';
        exit;
    break;

    case 'deleteReview':
         // Filter and store the data
         $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
         $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
         $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
   
         // Send the data to the model
         $deleteResult = deleteReview($reviewId);
   
         // Check and report the result
         if($deleteResult) {
           $message = "<p class='success'>Congratulations, the review was successfully deleted.</p>";
           $_SESSION['message'] = $message;
           header('location: /phpmotors/reviews/');
           exit;
   
         } else {
           $message = "<p class='emptyField'>Error. The review was not deleted.</p>";
           $_SESSION['message'] = $message;
             header('location: /phpmotors/reviews/');
           exit;
         }
     
    break;
    
    default:    
     include '../view/admin.php';
    break;
}

?>