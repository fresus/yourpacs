function checkThematic(num)
{
	return true;
}

function testFields(acronym, textos)
{
	var formulario = document.getElementById("fnewaccount");

	var error      = false;
	var errort     = false;
	var erroremail = false;
	var account    = document.getElementById('account');
	var email      = document.getElementById('email');
	var cemail     = document.getElementById('cemail');
	var passwd     = document.getElementById('passwd');
	var cpasswd    = document.getElementById('cpasswd');
	var captcha    = document.getElementById('captcha');
	//var thematic   = document.getElementById('thematic');
	var terms      = document.getElementById('terms');

	var accounterror  = document.getElementById('accounterror');
	var emailerror    = document.getElementById('emailerror');
	var passwderror   = document.getElementById('passwderror');
	var captchaerror  = document.getElementById('captchaerror');
	//var thematicerror = document.getElementById('thematicerror');
	var termserror    = document.getElementById('termserror');

	// Comprobamos el email
	if (Trim(email.value).length == 0 || Trim(cemail.value).length == 0) {
		error      = true;
		erroremail = true;
		email.className = "error";
		cemail.className = "error";
		emailerror.innerHTML = textos[0]; //"Es obligatoria";
	}
	else if (email.value != cemail.value) {
		error      = true;
		erroremail = true;
		email.className = "error";
		cemail.className = "error";
		emailerror.innerHTML = textos[1]; //"No coinciden";
	}
	else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
		error      = true;
		erroremail = true;
		email.className = "error";
		cemail.className = "error";
		emailerror.innerHTML = textos[2]; //"No es válida o no existe";
	}
	else {
		email.className = "text";
		cemail.className = "text";
		emailerror.innerHTML = "";
	}

	// Comprobamos el password
	if (Trim(passwd.value).length < 6) {
		error = true;
		passwd.className = "error";
		cpasswd.className = "error";
		passwderror.innerHTML = textos[3]; //"6 caracteres como mínimo";
	}
	else if (passwd.value != cpasswd.value) {
		error = true;
		passwd.className = "error";
		cpasswd.className = "error";
		passwderror.innerHTML = textos[4]; //"No coinciden";
	}
	else {
		passwd.className = "text";
		cpasswd.className = "text";
		passwderror.innerHTML = "";
	}

	// Comprobamos la tematica
/*	for (var i = 1; i <= 3; i++) {
		if (!document.getElementById("radioThematic" + i).checked) {
			errort = true;
		}
		else {
			errort = false;
			break;
		}
	}
	if (errort) {
		error = true;
		thematicerror.innerHTML = textos[5]; //"Elige una temática";
	}
	else {
		thematicerror.innerHTML = "";
	}
*/

	// Terminos y condiciones
	if (!terms.checked) {
		error = true;
		termserror.innerHTML = textos[6]; //"No has aceptado";
	}
	else {
		termserror.innerHTML = "";
	}

	// Comprobamos el nombre
	var http = getHTTPObject();
	http.open("post", "/" + acronym + "/verifyaccount", true);
	http.onreadystatechange = function() {
		if (http.readyState == 4)
		{
			var response = http.responseText.split("|");
			if (response[0] > 0 || response[2] > 0 || response[4] > 0)
			{
				error = true;

				if (response[0] > 0) {
					account.className = "error";
					accounterror.innerHTML = response[1];
				}
				else {
					account.className = "text";
					accounterror.innerHTML = "";
				}

				if (!erroremail)
				{
					if (response[2] > 0) {
						email.className  = "error";
						cemail.className = "error";
						emailerror.innerHTML = response[3];
					}
					else {
						email.className  = "text";
						cemail.className = "text";
						emailerror.innerHTML = "";
					}
				}

				if (response[4] > 0) {
					captcha.className = "captchaerror";
					captchaerror.innerHTML = response[5];
				}
				else {
					captcha.className = "captcha";
					captchaerror.innerHTML = "";
				}
			}
			else
			{
				account.className = "text";
				accounterror.innerHTML = "";
				captcha.className = "captcha";
				captchaerror.innerHTML = "";

				if (!erroremail)
				{
					email.className  = "text";
					cemail.className = "text";
					emailerror.innerHTML = "";
				}

				if (!error) {
					formulario.submit();
					return true;
				}
			}
		}
	}
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.send("account=" + escape(account.value) + "&email=" + escape(email.value) + "&captcha=" + escape(captcha.value));
}
