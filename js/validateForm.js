$(document).ready(function(){
	function passwordsMatch(){
		return $('#password').val() == $('#confirmpassword').val();
	}
	
	$('#password, #confirmpassword').on('keyup', function () {
	  if ($('#password').val() == $('#confirmpassword').val()) {
		$('#message').html('Passwords Matching').css('color', 'green');
	  } else 
		$('#message').html('Passwords Not Matching').css('color', 'red');
	});
	
	$('#register').submit(function(event){
		if(!passwordsMatch()){
			event.preventDefault();
			alert("The Passwords Do Not Match");
		}
	});
});