// Select input elements
let classNames = document.querySelectorAll(".modal-body .form-group input[type=text]");
let classTimes = document.querySelectorAll(".modal-body .form-group input[type=time]");
let classDays = document.querySelectorAll(".modal-body .form-group select");
// Select small tags for input elements
let namesSmall = document.querySelectorAll(".namesSmall");
let timesSmall = document.querySelectorAll(".timesSmall");
let daysSmall = document.querySelectorAll(".daysSmall");
let modalFooters = document.querySelectorAll(".modal-footer .btn-outline-primary");

// Oninput for names
for (let i = 0; i < classNames.length; i++){
	classNames[i].oninput = function(){
		if(this.value.length > 50){
			this.classList.add("is-invalid");
			namesSmall[i].classList.add("text-danger");
			namesSmall[i].classList.remove("text-muted");
		} else{
			this.classList.remove("is-invalid");
			namesSmall[i].classList.remove("text-danger");
			namesSmall[i].classList.add("text-muted");
		}
	}
}
// Onchange for time
for(let i = 0; i < classTimes.length; i++){
	classTimes[i].onchange = function(){
		this.classList.remove("is-invalid");
		timesSmall[i].classList.remove("text-danger");
		timesSmall[i].classList.add("text-muted");
	}
}

// Onchange for day
for(let i = 0; i < classDays.length; i++){
	classDays[i].onchange = function(){
		this.classList.remove("is-invalid");
		daysSmall[i].classList.remove("text-danger");
		daysSmall[i].classList.add("text-muted");
	}
}

for(let i = 0; i < modalFooters.length; i++){
	modalFooters[i].onclick = function(event){
		if(classNames[i].value.length == 0 || classNames[i].value.length > 50){
			event.preventDefault();
			classNames[i].classList.add("is-invalid");
			namesSmall[i].classList.add("text-danger");
			namesSmall[i].classList.remove("text-muted");
		}
		if(classDays[i].value == "0"){
			event.preventDefault();
			classDays[i].classList.add("is-invalid");
			daysSmall[i].classList.add("text-danger");
			daysSmall[i].classList.remove("text-muted");
		}
		if(classTimes[i].value == ""){
			event.preventDefault();
			classTimes[i].classList.add("is-invalid");
			timesSmall[i].classList.add("text-danger");
			timesSmall[i].classList.remove("text-muted");
		}
	}
}
