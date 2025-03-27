
const error = document.querySelector("#error");
const m=[document.querySelector("#mostra1"),document.querySelector("#mostra2"),document.querySelector("#mostra6")]

const formu = document.firstContact;
const ptremail = /^[a-z0-9_-]+([.][a-z0-9_-]+)*@[a-z0-9_]+([.][a-z0-9_]+)*[.][a-z]{2,9}$/;
const ptrasunto = /^[A-Za-zÀ-ÿ-\u00f1\u00d1\s]{5,40}$/;

const ptrcontent = /[A-Za-zÀ-ÿ-\u00f1\u00d1\s]{10,250}$/;
const form=[formu.email,formu.asunto,formu.contenido];

formu.addEventListener("submit", (e) => {
	const mymail = mail(), myasunto = asunt(),mycontent = content();
	if (!mymail || !myasunto || !mycontent) {
		e.preventDefault();
		error.innerHTML ="ERRORUM   No se ha podido enviar el formulario. Por favor, revisa que todos los campos estén rellenados correctamente.";
		error.style.color = "#FF0000";
		return false;
	} else {
		formu.submit();
		return true; 
	}
});

const avisoReset = () => {
	const reset = confirm(
		"ATENCIÓN!!!!!!!\nSi confirmas, se borraran todos los datos del formulario"
	);
	reset ? location.reload(true) : false;
};

const mail = () => {
	let correo = form[0].value;
	if (!correo.match(ptremail)) return false; return true;
};

const asunt = () => {
	let asunto = form[1].value;
	if (!asunto.match(ptrasunto)) return false; return true;
};


const content = () => {
	let content = form[2].value;
	if (!content.match(ptrcontent)) return false; return true;
};


const pasaValor = (event) => {
	let result;
	switch (event.target.name) {
		case "email":
			result = mail();
			if (result) {
				m[0].innerHTML = ". Email correcto";
				m[0].style.color = "#068B3E";
				form[0].style.border = "solid 2px green";
			} else {
				m[0].innerHTML = ". Email no válido. se esperaba una (@) y un (.)";
				m[0].style.color = "#FF0000";
				form[0].style.border = "solid 2px red";
			}
			break;
		case "asunto":
			result = asunt();
			if (result) {
				m[1].innerHTML = ". Asunto dentro de parámetros";
				m[1].style.color = "#068B3E";
				form[1].style.border = "solid 2px green";
			} else {
				m[1].innerHTML = ". Asunto no válido. SE SIENTEEEEE";
				m[1].style.color = "#FF0000";
				form[1].style.border = "solid 2px red";
			}
			break;
		case "contenido":
			result = content();
			if (result) {
				m[2].innerHTML = ". Contenido válido";
				m[2].style.color = "#068B3E";
				form[4].style.border = "solid 2px green";
			} else {
				m[2].innerHTML = ". Contenido no válido. SE SIENTEEEEE";
				m[2].style.color = "#FF0000";
				form[2].style.border = "solid 2px red";
			}
			break;
	}
};

const listeners = [formu.email,formu.asunto,formu.contenido];


for (const listener of listeners)
	listener.addEventListener("keyup", pasaValor);

formu.borrar.addEventListener("click", avisoReset);
