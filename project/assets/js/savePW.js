//variable



document.addEventListener('DOMContentLoaded', function(){
	var btnSubmit = document.getElementById('submitBtn');
	var inputEmail = document.getElementById('email');
	var inputPassword = document.getElementById('password');
	
	if(btnSubmit)
	{
			
			btnSubmit.addEventListener('click', function(){
			var valid = true;
			var emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
			
			if(!inputEmail.value.lenght || !inputEmail.value.match(emailReg))
			{
				giveErrorMsg('Bitte gültige Email eingeben');
				valid = false;
			}
			
			if(!inputPassword.value.lenght || inputPassword.value.lenght < 8){
				giveErrorMsg('Passwort ungültig');
				valid = false;
				
			}
			
			if(valid === false)
			{
				event.preventDefault();
				event.stopPropagation();	
			}
			
			return valid;
			
		});
		
	}
	
});

function giveErrorMsg(string) {

  var currentElement = document.getElementById("errorfield");
  currentElement.innerHTML=(string);
  
}























