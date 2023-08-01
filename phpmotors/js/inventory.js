'use strict' //the 'use strict' directive tells the JavaScript parser to follow all rules strictly.
 
 // Get a list of vehicles in inventory based on the classificationId 
 let classificationList = document.querySelector("#classificationList"); 
 classificationList.addEventListener("change", function () { 
    let classificationId = classificationList.value; 
    console.log(`classificationId is: ${classificationId}`); 
    let classIdURL = "/phpmotors/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId; 
  fetch(classIdURL) 
  .then(function (response) { //waits for data to be returned from the fetch
   if (response.ok) { 
    return response.json(); 
   } 
   throw Error("Network response was not OK"); 
  }) 
  .then(function (data) { //Accepts the JavaScript object from line 12, 
   console.log(data); 
   // parse the data into HTML table elements and inject them into the vehicle management view
   buildInventoryList(data); 
  }) 
  .catch(function (error) { 
   console.log('There was a problem: ', error.message) 
  }) 
 })

// Build inventory items into HTML table components and inject into DOM 
function buildInventoryList(data) { 
    let inventoryDisplay = document.getElementById("inventoryDisplay"); 
    // Set up the table labels 
    let dataTable = '<thead>'; 
    dataTable += '<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>'; 
    dataTable += '</thead>'; 
    // Set up the table body 
    dataTable += '<tbody>'; 
    // Iterate over all vehicles in the array and put each in a row 
    data.forEach(function (element) { 
     console.log(element.invId + ", " + element.invModel); 
     dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`; 
     dataTable += `<td><a class="edit" href='/phpmotors/vehicles?action=mod&invId=${element.invId}' title='Click to modify'>Modify</a></td>`; 
     dataTable += `<td><a class="del" href='/phpmotors/vehicles?action=del&invId=${element.invId}' title='Click to delete'>Delete</a></td></tr>`; 
    }) 
    dataTable += '</tbody>'; 
    // Display the contents in the Vehicle Management view 
    inventoryDisplay.innerHTML = dataTable; 
   }