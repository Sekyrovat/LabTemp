$('#newPicSubmit').on("click",function(event){
	event.preventDefault();
	
});

$.ajax({
	url : '../data/loadProfileDataPHP.php',
	type : 'GET',
	dataType : 'json',
	success : function(data){
		if (data.status === 'notLoggedIn')
    	{
    		window.location.replace("../index.html");
    	}
	    	
		let temp = "";
		if (data.userGender == 0) 
		{
			temp = "Female";
		} 
		else 
		{
			temp = "Male";
		}

		let newHtml = ``;

		newHtml += `<p id="userName">${data.username}</p>
		<p id="fName">${data.userFiName}</p>
		<p id="lName">${data.userLaName}</p>
		<p id="eMail">${data.userEmail}</p>
		<p id="gender">${temp}</p>
		<p id="country">${data.userCountry}</p>`;

		$('#userAccountInfo').append(newHtml);
	},
	error : function(errorMsg){
		console.log(errorMsg);
	}
});