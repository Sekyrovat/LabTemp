$("#loginRemMe").change(function() {
    if(this.checked) 
    {
        if ($("#loginUserName").val() != "" && $("#loginUserName").val() != null) 
        {
        	setCookie("username", $("#loginUserName").val(), 30);
    	}
    }
    else
    {
    	setCookie("username", "", -1);
    }
});

function checkCookie() {
	let userX = getCookie("username");
    if (userX != "") {
        $("#loginUserName").val(userX);
    }
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    let d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


$(document).ready(function () {
	checkCookie();
});

$('#loginSubmit').on("click",function(event){
	event.preventDefault();
	if (validateLogin()){

		let jsonToSend ={
						"userName" : $("#loginUserName").val(),
						"userPassword" : $("#loginUserPass").val()
					};

		$.ajax({
			url : "./data/loginToAccountPHP.php",
			type : "POST",
			data : jsonToSend,
			ContentType : "json",
			dataType : "json",
			success : function(data){
				if (data.status === "success")
				{
					location.href = "./html/homePage.html";
					console.log(data);
				}
			},
			error : function(error){
				console.log(error);
			}
		});
	}
});

function validateLogin(){
	
	let uNameError = $('#userNameError');
	let uPassEerror = $('#userPassError');

	let verifier = true;

	if ($('#loginUserName').val() == "")
	{
		uNameError.text(`Please provide your username`);
		verifier = false;
	}
	else
	{
		uNameError.text(``);
	}

	if ($('#loginUserPass').val() == "")
	{
		uPassEerror.text(`Please provide your password`);
		verifier = false;
	}
	else
	{
		uPassEerror.text(``);
	}

	return verifier;
}