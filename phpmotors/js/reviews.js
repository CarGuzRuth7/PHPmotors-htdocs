'use strict'

let reviewList = document.querySelector("#review-list");
let clientId = reviewList.getAttribute("data-userId");
//console.log(clientId);
let reviewIdURL ="/phpmotors/reviews/index.php?action=getReviews&clientId=" + clientId; 
fetch(reviewIdURL)
.then(function (response) { //waits for data to be returned from the fetch
    if (response.ok) { 
     return response.json(); 
    } 
    throw Error("Network response was not OK"); 
   }) 
.then(function (data) { //Accepts the JavaScript object from line 12, 
  //  console.log(data); 
    // parse the data into HTML table elements and inject them into the vehicle management view
    buildReviewListByClient(data); 
   }) 
.catch(function (error) { 
    console.log('There was a problem: ', error.message) 
   }) 
  
  
function buildReviewListByClient(review){
    let reviewList = document.querySelector("#review-list");
    let rw = "<h2>Manage Your Product Reviews</h2>";
    if(review.length === 0){
        console.log("working")
        reviewList.innerHTML =  "<h2>Manage Your Product Reviews</h2><p>You don't have reviews yet</p>";
    }else{

    rw += "<ul>";

    console.log(review)
    review.forEach(element =>{
        let d = new Date(element.reviewDate);
        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];
        let date = `${d.getDate()}  ${ months[d.getMonth()]}, ${d.getFullYear()}`;

        rw += `<li><p>${element.invMake} ${element.invModel} (Reviewed on ${date}) `;
        rw += `| <a class="edit" href="/phpmotors/reviews?action=editReview&reviewId=${element.reviewId}" title="Click to modify">Edit</a>`;
        rw += ` | <a class="del" href="/phpmotors/reviews?action=confirmDelete&reviewId=${element.reviewId}" title="Click to delete">Delete</a></p>`;
        rw += `</li>`;
    })
     rw += "</ul>";

    reviewList.innerHTML = rw;
}
}