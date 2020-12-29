// Select input elements
let emailInput = document.querySelector("#email-input");
let passwordInput = document.querySelector("#password-input");
// Select output element
let errorRow = document.querySelector("#error-message");
// Prevent submission if invalid inputs
document.querySelector("#login-form").onsubmit = function(event) {
	if((emailInput.value.length == 0) || (passwordInput.value.length == 0)){
		event.preventDefault();
		errorRow.innerHTML = "Please enter an email and a password."
	}
}