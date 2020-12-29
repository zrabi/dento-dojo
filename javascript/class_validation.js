// Select input elements
let className = document.querySelector("#class-form-name");
let classTime = document.querySelector("#new-class-time");
let classDay = document.querySelector("#new-class-day");
// Select small tags for input elements
let nameSmall = document.querySelector("#class-help");
let timeSmall = document.querySelector("#time-help");
let daySmall = document.querySelector("#day-help");

className.oninput = function(){
	if(className.value.length > 50){
		className.classList.add("is-invalid");
		nameSmall.classList.add("text-danger");
		nameSmall.classList.remove("text-muted");
	} else{
		className.classList.remove("is-invalid");
		nameSmall.classList.remove("text-danger");
		nameSmall.classList.add("text-muted");
	}
}

classTime.onchange = function(){
	classTime.classList.remove("is-invalid");
	timeSmall.classList.remove("text-danger");
	timeSmall.classList.add("text-muted");
}

classDay.onchange = function(){
	classDay.classList.remove("is-invalid");
	daySmall.classList.remove("text-danger");
	daySmall.classList.add("text-muted");
}

// On submit
document.querySelector("#class-form").onsubmit = function(event){
	if(className.value.length == 0 || className.value.length > 50){
		event.preventDefault();
		className.classList.add("is-invalid");
		nameSmall.classList.add("text-danger");
		nameSmall.classList.remove("text-muted");
	}
	if(classDay.value == "0"){
		event.preventDefault();
		classDay.classList.add("is-invalid");
		daySmall.classList.add("text-danger");
		daySmall.classList.remove("text-muted");
	}
	if(classTime.value == ""){
		event.preventDefault();
		classTime.classList.add("is-invalid");
		timeSmall.classList.add("text-danger");
		timeSmall.classList.remove("text-muted");
	}
}

document.querySelector("#class-form .btn-secondary").onclick = function(){
	className.classList.remove("is-invalid");
	nameSmall.classList.remove("text-danger");
	nameSmall.classList.add("text-muted");
	classDay.classList.remove("is-invalid");
	daySmall.classList.remove("text-danger");
	daySmall.classList.add("text-muted");
	classTime.classList.remove("is-invalid");
	timeSmall.classList.remove("text-danger");
	timeSmall.classList.add("text-muted");

}