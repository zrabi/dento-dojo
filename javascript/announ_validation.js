// Select input elements
let titleField = document.querySelector("#announ-form-title");
let textField = document.querySelector("#announ-form-text");
// Select small tags for input elements
let titleSmall = document.querySelector("#title-help");
let textSmall = document.querySelector("#text-help");
// Whenever the user types
titleField.oninput = function() {
	if(titleField.value.length <= 100){
		titleField.classList.remove("is-invalid");
		titleSmall.classList.remove("text-danger");
		titleSmall.classList.add("text-muted");
	}
	else{
		titleField.classList.add("is-invalid");
		titleSmall.classList.add("text-danger");
		titleSmall.classList.remove("text-muted");
	}
}

textField.oninput = function(){
	if(textField.value.length <= 400){
		textField.classList.remove("is-invalid");
		textSmall.classList.remove("text-danger");
		textSmall.classList.add("text-muted");
	}
	else{
		textField.classList.add("is-invalid");
		textSmall.classList.add("text-danger");
		textSmall.classList.remove("text-muted");
	}
}

// Prevent submission if invalid inputs
document.querySelector("#announ-form").onsubmit = function(event) {
	if((titleField.value.length > 100) || (textField.value.length > 400)){
		event.preventDefault();
	}
	if((titleField.value.length == 0) || (textField.value.length == 0)){
		event.preventDefault();
		if(titleField.value.length == 0){
			titleField.classList.add("is-invalid");
			titleSmall.classList.add("text-danger");
			titleSmall.classList.remove("text-muted");
		}
		if(textField.value.length == 0){
			textField.classList.add("is-invalid");
			textSmall.classList.add("text-danger");
			textSmall.classList.remove("text-muted");
		}
	}
}

document.querySelector("#announ-form .btn-secondary").onclick = function(){
	textField.classList.remove("is-invalid");
	textSmall.classList.remove("text-danger");
	textSmall.classList.add("text-muted");
	titleField.classList.remove("is-invalid");
	titleSmall.classList.remove("text-danger");
	titleSmall.classList.add("text-muted");

}