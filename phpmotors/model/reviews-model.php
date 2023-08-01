<?php
//REVIEWS MODEL FOR VEHICLE INVENTORY 
/**
 * Insert a review
 * Get reviews for a specific inventory item
 * Get reviews written by a specific client
 * Get a specific review
 * Update a specific review
 * Delete a specific review
 */

//insert a review
function addNewReview($reviewText, $invId, $clientId) {
  $db = phpmotorsConnect();
  $sql = 'INSERT INTO reviews(reviewText, invId, clientId)
                     VALUES(:reviewText, :invId, :clientId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

//Get reviews for a specific inventory item
function getReviewbyInventory($invId){
  $db = phpmotorsConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, clients.clientId, clients.clientFirstname, clients.clientLastname 
    FROM reviews join clients on clients.clientId = reviews.clientId 
    WHERE invId = :invId ORDER BY reviewDate desc';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewArray;
}

//Get reviews written by a specific client
function getReviewbyClient($clientId){
  $db = phpmotorsConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, inventory.invId, inventory.invMake, inventory.invModel 
    FROM reviews join inventory ON reviews.invId = inventory.invId 
    WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewArray;

}

//Get a specific review
function getReview($reviewId){
  $db = phpmotorsConnect();
  $sql = 'SELECT reviewId, reviewText, reviewDate, inventory.invId, inventory.invMake, inventory.invModel
  FROM reviews 
  join inventory ON reviews.invId = inventory.invId 
  WHERE reviewId = :reviewId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->execute();
  $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $invInfo;

}

//Update a specific review
function updateReview($reviewId, $reviewText){
  //hacer coincidir con el id del cliente y del auto. solo actualiza el texto
  $db = phpmotorsConnect();
  $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);

  $stmt->execute();
  $result = $stmt->rowCount();
  $stmt->closeCursor();
  return $result;
}

//Delete a specific review
function deleteReview($reviewId){
  $db = phpmotorsConnect();
  $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->rowCount();
  $stmt->closeCursor();
  return $result;
}

?>