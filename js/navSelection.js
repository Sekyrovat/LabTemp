// We select the inmediate child elements
$('#navigationBars > section > a').on("click", function(event) {
	
	//Convention when targetting this way.
	let $selection = $(this);

	// console.log($(this));
	
	// Remove the class selected from the <li>
	// We don't need the '.' on the second selected since we already 
	// specified we are going to remove
	$('.selected').removeClass('selected');

	//Adding the class
	$selection.addClass('selected');
	// // Dunno if there is a reason
	// // $($selection).addClass('selected');

	// //console.log($selection.attr('class'));

	// let currentId = $($selection).attr('id');


	// // This works as a loop
	//  	// Hide previous <section>
	// $('main > section').addClass('hiddenElement');

	// // Show the current <Section> that has been clicked
	// // DONT USE SHOW, IT'LL OVERWRITE THE CSS
	// $('#'  + currentId + 'Section').removeClass('hiddenElement');

});

$('#logoutBtn').on("click",function (argument) {
	$.ajax({
		url : "../data/logoutService.php",
		type : "POST",
		success : function(data) {
			window.location.replace("../index.html");
		},
		error : function(err) {
			console.log(err);
		}
	});
});