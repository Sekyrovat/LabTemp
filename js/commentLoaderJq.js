$(document).ready(function () {
	$.ajax({
	    url : "../data/commentLoaderPHP.php",
	    type : "GET",
	    dataType : "json",
	    success : function(data){

	    	if (data.status === 'notLoggedIn')
	    	{
	    		window.location.replace("../index.html");
	    	}
			let newHtml = "";

			let posterId = "";
			let newText = "";
			let newImage = "";
			let posterUserName = "";
			let posterProfilePic = "";

			for(var i = 0; i<data.length; ++i)
			{
				posterId = data[i].posterId;
				newText = data[i].postText;
				newImage = data[i].postImage;
				posterUserName = data[i].posterUserName;
				posterProfilePic = data[i].posterProfilePic;


				if(newText != "" && newImage != "")
				{
					newHtml +=  `<label class="modalCaller">
									<!--vwesvwe -->
									<section class='cards'> 
										<h3 name='user' class='postOwner'> ${posterUserName} </h3>
										<img src="${posterProfilePic}" class="userProfilePic">
										<img src='${newImage}' name='image' class='postImage'>
										<br>
										<p name='text' class='postText'>
											${newText}
										</p>
									</section>
								 </label>`;
				}
				else if (newText == "" && newImage != "")
				{
					newHtml +=  `<label class="modalCaller">
									<section class='cards'>
										<h3 name='user' class='postOwner'> ${posterUserName} </h3>
										<img src="${posterProfilePic}" class="userProfilePic">
										<img src='${newImage}' name='image' class='postImage'>
									</section>
								</label>`;
				}
				else if(newText != "" && newImage == "")
				{
					newHtml += `<label class="modalCaller">
									<section class='cards'>
										<h3 name='user' class='postOwner'> ${posterUserName} </h3>
										<img src="${posterProfilePic}" class="userProfilePic">
										<br>
										<p name='text' class='postText'>
											${newText}
										</p>
									</section>
								</label>`;
				}
			};
			$('#mainContent').append(newHtml);
	    },
	    error : function(err){
	        console.log(err);
	    	console.log("x");
	    	//console.log(JSON.parse(err));

	    }
	});
});

// // Get the modal
// var modal = document.getElementById('myModal');

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // When the user clicks on the button, open the modal
// $('.modalCaller').onclick = function() {
    
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// } 

// $(document).on("click",".modalCaller", function () {
//    // var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id
//    // alert('you clicked on button #' + clickedBtnID);
//    $(this).modal.style.display = "block";
// });