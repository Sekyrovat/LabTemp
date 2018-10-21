$('#registerSubmit').on("click", function (event) {
	event.preventDefault();

	if(validateRegistration() && validateRadioButtons() && validateDropDownMenu())
	{
		let jsonToSend = {
						"userFirstName" : $("#registrationUserFname").val(),
						"userLastName" : $("#registrationUserLname").val(),
						"userName" : $("#registrationUserName").val(),
						"userEmail" : $("#registrationUserEmail").val(),
						"userPassword" : $("#registrationUserPass1").val(),
						"userGender" : $("input[name='genderRadioButton']:checked").val(),
						"userCountry" : $("#natCountry").val()
					};

		$.ajax({
			url : "./data/registerAccountPHP.php",
			type : "POST",
			data : jsonToSend,
			ContentType : "json",
			dataType : "json",
			success : function(data){
				console.log(data);
				if (data.status === "success")
				{
					window.location.replace("./login.html");
				}
				else
				{
					uNameError.text(`Username already taken.`);
				}
			},
			error : function(error){
				alert(error.responseText);
				console.log(error);
			}
		});
	}
});

$('#resetBtn').on("click",function(event) {
	event.preventDefault();
	relod();
});

function validateRegistration() {

	let verifier = true;

	let fName = $('#registrationUserFname');
	let fNameError = $('#errorFName');

	let lName = $('#registrationUserLname');
	let lNameError = $('#errorLName');

	let uName = $('#registrationUserName');
	let uNameError = $('#errorUName');

	let uMail = $("#registrationUserEmail");
	let uMailError = $('#errorEmail');


	let uPass1 = $('#registrationUserPass1');
	let uPass1Error = $('#errorPass1');
	let uPass2 = $('#registrationUserPass2');
	let uPass2Error = $('#errorPass2');

	if (fName.val() == ""){
		fNameError.text(`Please provide your name.`);
		verifier = false;
	}
	else{
		fNameError.text(``);
	}

	if (lName.val() == ``)
	{
		lNameError.text(`Please provide your last name`);
		verifier = false;
	}
	else
	{
		lNameError.text(``);
	}

	if (uName.val() == "")
	{
		uNameError.text(`Please provide a username`);
		verifier = false;
	}
	else
	{
		uNameError.text(``);
	}

	let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
	if (!uMail.val().match(re))
	{
		uMailError.text(`Please provide an email address`);
		verifier = false;
	}
	else
	{
		uMailError.text(``);
	}
	if (uPass1.val() == "")
	{
		uPass1Error.text(`Please provide a password`);
		verifier = false;
	}
	else
	{
		uPass1Error.text(``);
	}
	if(uPass2.val() != uPass1.val())
	{
		uPass2Error.text(`Passwords don't match`);
		verifier = false;
	}
	else
	{
		uPass2Error.text(``);
	}

	return verifier;
}


function validateRadioButtons() {
	let selectedFlag = true;
	let userGenderError = $("#errorGender");
	
	if (!$('input[name=genderRadioButton]:checked').val() )
	{
		userGenderError.text(`Please select a Gender`);
		selectedFlag = false;
	} else {
		userGenderError.text(``);
	}
	return selectedFlag;
}

function validateDropDownMenu() {
	let userCountry = $('#natCountry');
	let userCountryError = $('#errorCountry');
	let selectedFlag = false;

	if (userCountry.val() == "0")
	{
		userCountryError.text(`Please select your coutnry`);
	}
	else
	{
		userCountryError.text(``);
		selectedFlag = true;
	}
	return selectedFlag;
}


function relod(){
	$('#registrationUserFname').val(``);
	$('#errorFName').text(``);

	$('#registrationUserLname').val(``);
	$('#errorLName').text(``);

	$('#registrationUserName').val(``);
	$('#errorUName').text(``);
	
	$('#registrationUserEmail').val(``);
	$('#errorEmail').text(``);

	$('#registrationUserPass1').val(``);
	$('#errorPass1').text(``);

	$('#registrationUserPass2').val(``);
	$('#errorPass2').text(``);


	$('.gender').prop('checked', false);
	$('#errorGender').text(``);


	$('#natCountry').prop('selectedIndex',0)
	$('#errorCountry').text(``);
}