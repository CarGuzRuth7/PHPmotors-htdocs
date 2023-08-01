<?php
/* VEHICLES MODEL
 */
 //Function to inserting a new classification to the carclassification table.
 function addClassification($classificationName){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO carclassification (classificationName)
        VALUES (:classificationName)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    
   //   $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
  }

 //Function to inserting a new classification to the carclassification table.
 function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId)
                           VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);


    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
  }

// Get vehicles by classificationId 
  function getInventoryByClassification($classificationId){ 
   $db = phpmotorsConnect(); 
   $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
   $stmt = $db->prepare($sql); 
   $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
   $stmt->execute(); 
   $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
   $stmt->closeCursor(); 
   return $inventory; 
   }

//Select a single vehicle based on its id
// Get vehicle information by invId
  function getInvItemInfo($invId){
   $db = phpmotorsConnect();
   $sql = 'SELECT * FROM inventory WHERE invId = :invId';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
   $stmt->execute();
   $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
   $stmt->closeCursor();
   return $invInfo;
   }

// Get vehicle information by invId but with primary images from images table
function getVehicleInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT inventory.invId, invMake, invModel, invDescription, invPrice, invStock, invColor, classificationId, images.imgPath
    FROM inventory inner join images on images.invId = inventory.invId
    WHERE images.imgPrimary = 1 and inventory.invId = :invId';
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
    }

//Function to update car info in inventory table.
  function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId){
   // Create a connection object using the phpmotors connection function
   $db = phpmotorsConnect();
   // The SQL statement
   $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, 
    invDescription = :invDescription, invImage = :invImage, 
    invThumbnail = :invThumbnail, invPrice = :invPrice, 
    invStock = :invStock, invColor = :invColor, 
    classificationId = :classificationId WHERE invId = :invId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);

    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   } 
//Function to delete car info in inventory table.
  function deleteVehicle($invId){

   $db = phpmotorsConnect();
   $sql = 'DELETE FROM inventory WHERE invId = :invId';
   // Create the prepared statement using the phpmotors connection
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
   $stmt->execute();
   $rowsChanged = $stmt->rowCount();
   $stmt->closeCursor();
   return $rowsChanged;
  } 

//Get a list of vehicles based on the classification
  function getVehiclesByClassification($classificationName){
   $db = phpmotorsConnect();
   $sql = 'SELECT inventory.invId, inventory.invMake, inventory.invModel, inventory.invDescription, inventory.invPrice , inventory.invStock, inventory.invColor, inventory.classificationId, images.imgPath 
   FROM inventory join images on images.invId = inventory.invId
   WHERE images.imgPrimary = 1 and images.imgPath LIKE "%-tn%" and inventory.classificationId  
      IN (SELECT classificationId 
            FROM carclassification 
            WHERE classificationName = :classificationName)';
            
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
   $stmt->execute();
   $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
   $stmt->closeCursor();
   return $vehicles;
  }

//  Get information for all vehicles
  function getVehicles(){
  	$db = phpmotorsConnect();
  	$sql = 'SELECT invId, invMake, invModel FROM inventory';
  	$stmt = $db->prepare($sql);
  	$stmt->execute();
  	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
  	$stmt->closeCursor();
  	return $invInfo;
  } 
  
?>