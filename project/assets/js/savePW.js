//variable



document.addEventListener('DOMContentLoaded', function(){
	var btnSubmit = document.getElementById('submitBtn');
	var inputEmail = document.getElementById('email');
	var inputPassword = document.getElementById('password');
	
	if(btnSubmit)
	{
			alert("geht");
		btnSubmit.addEventListener('click', function(event){
			var valid = true;
			var emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
			
			if(!inputEmail || !inputEmail.value.match(emailReg))
			{
				giveErrorMsg('Die Eingegebenen Daten sind nicht korrekt');
				valid = false;
			}
			
			var regex = /^(?=.*?[A-Z].*?[A-Z])(?=.*?[a-z].*?[a-z])(?=.*?[0-9].*?[0-9])(?=.*?[^\w\s].*?[^\w\s]).{12,}$/m;
			if(!inputPassword || inputPassword.value.lenght < 8 || !inputPassword.value.match(regex))
			{
				giveErrorMsg('Die Eingegebenen Daten sind nicht korrekt');
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
	
	if(inputPassword)
	{
		
		
		inputPassword.addEventListener('keyup', function(){
			
			var regex1 = /^(?=.*?[A-Z].*?)(?=.*?[a-z].*?)(?=.*?[0-9].*?).{6,}$/m;
			var regex2 = /^(?=.*?[A-Z].*?)(?=.*?[a-z].*?[a-z])(?=.*?[0-9].*?[0-9])(?=.*?[^\w\s].*?).{8,}$/m;
			var regex3 = /^(?=.*?[A-Z].*?[A-Z])(?=.*?[a-z].*?[a-z])(?=.*?[0-9].*?[0-9])(?=.*?[^\w\s].*?[^\w\s]).{12,}$/m;
			
			if(inputPassword.value.match(regex3))
			{
				input.Password.style.border = '2px solid green';
			}
			else if(inputPassword.value.match(regex2))
			{
				inputPassword.style.border = '2px solid blue';
			}
			else if(inputPassword.value.match(regex1))
			{
				inputPassword.style.border = '2px solid yellow';
			}
			else
			{
				inputPassword.style.border = '2px solid red';
			}
			
		});
	}
	
});

function giveErrorMsg (string) {

  var currentElement = document.getElementById("errorfield");
  currentElement.innerHTML=(string);
  
}























