//For giving the user errors when he does something wrong in the registration



document.addEventListener('DOMContentLoaded', function(){
	var btnSubmit = document.getElementById('submitBtn');
	var inputEmail = document.getElementById('email');
	var inputPassword = document.getElementById('password');
	var inputPassword2 = document.getElementById('password2');
	var inputFirstname = document.getElementById('firstname');
	var inputLastname = document.getElementById('lastname');
	var inputCity = document.getElementById('city');
	var inputZipcode = document.getElementById('zipcode');
	var inputStreet = document.getElementById('street');
	var inputnumber = document.getElementById('number');
	
	
	if(btnSubmit)
	{
		
		btnSubmit.addEventListener('click', function(){
			var valid = true;
			var emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
			var regex = /^(?=.*?[A-Z].*?)(?=.*?[a-z].*?[a-z])(?=.*?[0-9].*?[0-9])(?=.*?[^\w\s].*?).{8,}$/m;
					
			
			if(!inputnumber.value.length)
			{
				giveErrorMsg('Bitte Hausnummer eingeben');
				valid = false;
				
				inputnumber.style.border = '2px solid red';
			}
					
			if(!inputStreet.value.length)
			{
				giveErrorMsg('Bitte Straße eingeben');
				valid = false;
				
				inputStreet.style.border = '2px solid red';
			}
						
			if(!inputZipcode.value.length)
			{
				giveErrorMsg('Bitte Postleitzahl eingeben');
				valid = false;
				
				inputZipcode.style.border = '2px solid red';
			}
			
			if(!inputCity.value.length)
			{
				giveErrorMsg('Bitte Stadt eingeben');
				valid = false;
				
				inputCity.style.border = '2px solid red';
			}
			
			if(!inputPassword2.value.length)
			{
				giveErrorMsg('Passwort bitte ein zweites mal eingeben');
				valid = false;
				
				inputPassword2.style.border = '2px solid red';
			}
						
			if(!inputPassword.value.length || !inputPassword.value.match(regex))
			{
				giveErrorMsg('Passwort ist zu unsicher, bitte mindestens 12 Stellen, groß und kleinschreibung sowie Zahlen und Sonderzeichen verwenden');
				valid = false;
				
				inputPassword.style.border = '2px solid red';
				
			}
						
			if(!inputEmail.value.length || !inputEmail.value.match(emailReg))
			{
				giveErrorMsg('Bitte gültige Email eingeben');
				valid = false;
				
				inputEmail.style.border = '2px solid red';
			}
						
			if(!inputLastname.value.length)
			{
				giveErrorMsg('Bitte Nachname eingeben');
				valid = false;
				
				inputLastname.style.border = '2px solid red';
			}
						
			if(!inputFirstname.value.length)
			{
				giveErrorMsg('Bitte Vorname eingeben');
				valid = false;
				
				inputFirstname.style.border = '2px solid red';
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
		
		//gives the user a feedback when the password is safe enough
		inputPassword.addEventListener('keyup', function(){
			
			var regex1 = /^(?=.*?[A-Z].*?)(?=.*?[a-z].*?)(?=.*?[0-9].*?).{6,}$/m;
			var regex2 = /^(?=.*?[A-Z].*?)(?=.*?[a-z].*?[a-z])(?=.*?[0-9].*?[0-9])(?=.*?[^\w\s].*?).{8,}$/m;
			
			var str = this.value;
			
			
			if(inputPassword.value.match(regex2))
			{
				inputPassword.style.border = '2px solid green';
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