/**
 * Funciones para el debug
 * Moviendo capas (DRAG AND DROP)
 */
var capa = null;
var _IE_ = navigator.userAgent.indexOf("MSIE") != -1;

function liberaCapa()
{
	capa.style.opacity = "0.90";
	capa = null;
}

function clickCapa(e, obj)
{
	capa = obj.parentNode;

	capa.style.opacity = "0.40";

	if (_IE_) {
		difX = e.offsetX;
		difY = e.offsetY;
	} else {
		difX = e.layerX;
		difY = e.layerY;
	}
}

function mueveCapa(e)
{
	if (capa != null) {
		capa.style.top = (e.clientY-difY)+"px";
		capa.style.left = (e.clientX-difX)+"px";
	}
}

function esconder(capa)
{
	var elements = capa.getElementsByTagName("pre");

	if (elements[0].style.display == "none") {
		elements[0].style.display = "block";
	}
	else {
		elements[0].style.display = "none";
		capa.style.width = capa.offsetWidth;
	}
}

function cerrar(capa)
{
	capa.style.display = "none";
}

document.onmousemove = function (e) {
							if (!e) e = window.event;
							mueveCapa(e);
						}
