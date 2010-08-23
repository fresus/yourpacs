var qMBytes = 0;


function checkStartWeb(num)
{
	if (num == 1) {
		var disabled = true;
	}
	else {
		var disabled = false;
	}

	for (i = 1; i <= 5; i++)
	{
		var radio = document.getElementById("start" + i);
		radio.disabled = disabled;
	}

	return true;
}

function checkThematic(num)
{
	for (var i = 1; i <= 3; i++)
	{
		var thematic = document.getElementById("thematic" + i);

		if (i == num) {
			thematic.disabled = false;
		}
		else {
			thematic.disabled = true;
		}
	}

	return true;
}

function changeStatus(id)
{
	var img   = document.getElementById("img_" + id);
	var field = document.getElementById("soft_" + id);

	var imageok = document.getElementById("imgok_" + id);
	var imageko = document.getElementById("imgko_" + id);

	if (field.value == 'ok')
	{
		field.value = 'ko';
		img.src = "/img/software/" + imageko.value;
	}
	else
	{
		field.value = 'ok';
		img.src = "/img/software/" + imageok.value;
	}
}

function checkSoftInstallConfirm(id, text1, text2)
{
	if (!document.getElementById(id).checked) {
		alert(text1);
		return false;
	}

	if (confirm(text2)) {
		document.forms['softInstallForm'].submit();
	}

	return false;
}

function checkDeleteDomainConfirm(id, text1)
{
	if (document.getElementById(id).checked)
	{
		if (confirm(text1)) {
			document.forms['formConfigDomain'].submit();
		}
		else {
			return false;
		}
	}

	document.forms['formConfigDomain'].submit();
}

function checkConfigWp(id, text1)
{
	if (document.getElementById(id).checked)
	{
		if (confirm(text1)) {
			document.forms['formconfigwebs'].submit();
			return true;
		}
		else {
			return false;
		}
	}
	else
	{
		document.forms['formconfigwebs'].submit();
		return true;
	}

	return false;
}

function confirmDelete(delUrl) {
    if (confirm("Are you sure you want to delete")) {
        document.location = delUrl;
    }
}

