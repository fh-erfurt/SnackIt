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

				
			if(!inputPassword.value.length)
			{
				giveErrorMsg('Bitte Passwort eingeben');
				valid = false;
				
				inputPassword.style.border = '2px solid red';
				
			}
						
			if(!inputEmail.value.length || !inputEmail.value.match(emailReg))
			{
				giveErrorMsg('Bitte gültige Email eingeben');
				valid = false;
				
				inputEmail.style.border = '2px solid red';
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























