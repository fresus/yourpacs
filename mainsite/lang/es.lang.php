<?php
/**
Language Español
@file es.lang.php
@version 1.0
@date 3 de marzo del 2007
@author Macos Julian <marcos@Yourpacs.com>
@revision Azucena Casado

 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

# General
# ------------------------------------------------------------------------------
$LANG['general']['by']       = "Por";
$LANG['general']['of']       = "de";
$LANG['general']['to']       = "a";
$LANG['general']['and']      = "y";
$LANG['general']['or']       = "o";
$LANG['general']['with']     = "con";
$LANG['general']['years']    = "años";
$LANG['general']['author']   = "Autor";
$LANG['general']['the']      = "el";
$LANG['general']['day']      = "día";
$LANG['general']['accept']   = "Aceptar";
$LANG['general']['send']     = "Enviar";
$LANG['general']['comments'] = "Comentarios";

$LANG['general']['options'] = "Opciones";
$LANG['general']['help']    = "Ayuda";
$LANG['general']['save']    = "Guardar";
$LANG['general']['change']  = "Cambiar";

$LANG['general']['dayweek_0'] = "domingo";
$LANG['general']['dayweek_1'] = "lunes";
$LANG['general']['dayweek_2'] = "martes";
$LANG['general']['dayweek_3'] = "miércoles";
$LANG['general']['dayweek_4'] = "jueves";
$LANG['general']['dayweek_5'] = "viernes";
$LANG['general']['dayweek_6'] = "sábado";

$LANG['general']['email'] = "Dirección de email";

# E-Mails
# ------------------------------------------------------------------------------
$LANG['email']['nasubject'] = "Bienvenido a Yourpacs.";
$LANG['email']['nabody']    = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
							   <html><head>
							   <title>Yourpacs :: Confirmación de registro</title>
							   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
							   </head><body>
							   <h1>Bienvenido a Yourpacs</h1><br/>
							   Desde este momento ya puedes acceder a tu panel de control para empezar a 
                               enviar datos a cualquier usuario de Yourpacs.
                               <br/>
                               <br/>
                               En el panel de control, podrás encontrar los datos de configuración y el software 
                               necesario para empezar. También podrás actualizar tu cuenta a Yourpacs PRO para disponer de tu propio
                               PACS accesible des de cualquier sitio de internet!! ¿A qué esperas?
							   <br/><br/>
							   Estos son los datos de tu cuenta:<br/>
							   Cuenta: <strong>[%LOGIN%]</strong><br/>
							   Contraseña: <strong>[%PASSWD%]</strong><br/>
							   <br/>
							   Te damos las gracias por confiar en Yourpacs.<br/>
							   <a href='http://www.yourpacs.com'>http://www.yourpacs.com</a><br/>
							   support@yourpacs.com
							   </body></html>
							  ";
$LANG['email']['rpsubject'] = "Yourpacs. Recuperación de contraseña.";
$LANG['email']['rpbody']    = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
								<html><head>
								<title>Yourpacs :: Recuperación de contraseña</title>
								<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
								</head><body>
								<h1>Recuperación de contraseña</h1><br/>
								Se acaba de generar un código de seguridad para que puedas
								cambiar la contraseña de tu cuenta de Yourpacs. Este código
								caduca en 30 minutos. Si pasado ese tiempo no lo has utilizado
								dejará de ser válido y necesitarás volver a solicitarlo.
								<br/><br/>
								Estos son los datos de tu cuenta:<br/>
								Cuenta: <strong>[%LOGIN%]</strong><br/>
								e-Mail: <strong>[%EMAIL%]</strong><br/>
								<br/>
								Para cambiar la contraseña pulsa el siguiente enlace:<br/>
								<a href=\"[%URL%]\">[%URL%]</a>
								<br/><br/>
								Te damos las gracias por confiar en Yourpacs.<br/>
							   <a href='http://www.yourpacs.com'>http://www.yourpacs.com</a><br/>
								support@yourpacs.com
								</body></html>
								";

$LANG['email']['invsubject'] = "Alguien quiere que conozcas Yourpacs.";
$LANG['email']['invbody']    = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
							   <html><head>
							   <title>Yourpacs :: Invitación a Yourpacs</title>
							   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
							   </head><body>
							   <h1>Descubre Yourpacs</h1><br/>
                               El usuario [%USER%] con email [%EMAIL%] quiere que conozcas Yourpacs y
                               por eso te invita a que entres y te registres para empezar a usar este servicio.
                               <br/>
                               <br/>
                               Puedes empezar por leer <a href='http://www.yourpacs.com/es/help/whatis'>¿Que es Yourpacs?</a> y 
                               <a href='http://www.yourpacs.com/es/help/sothat'>¿Para qué sirve?</a>.
                               Sigue el consejo de tu amig@ y conocenos! ¿A qué esperas?
							   <br/><br/>
							   <a href='http://www.yourpacs.com'>http://www.yourpacs.com</a><br/>
							   support@yourpacs.com
							   </body></html>
							  ";
# Sections
# ------------------------------------------------------------------------------
$LANG['sections']['whatis']   = "¿Qué es ?";
$LANG['sections']['sothat']   = "¿Para qué sirve?";
$LANG['sections']['faq']  = "Preguntas frecuentes";
$LANG['sections']['doc']  = "Documentación";
$LANG['sections']['contact']  = "Contactar";
$LANG['sections']['register'] = "Crear una cuenta";
$LANG['sections']['help']     = "Ayuda";

# Pager
# ------------------------------------------------------------------------------
$LANG['pager']['page']  = "Página";
$LANG['pager']['pages'] = "Páginas";
$LANG['pager']['next']  = "Siguiente";
$LANG['pager']['prev']  = "Anterior";
$LANG['pager']['first'] = "Primera";
$LANG['pager']['last']  = "Última";

# Summary
# ------------------------------------------------------------------------------
$LANG['summary']['pagetitle']   = "Yourpacs :: ";
$LANG['summary']['optionblog']  = "Blog";
$LANG['summary']['optionalbum'] = "Álbum";
$LANG['summary']['optionwiki']  = "Wiki";
$LANG['summary']['optionlinks'] = "Enlaces";
$LANG['summary']['optionforum'] = "Foro";

$LANG['summary']['lastphotos'] = "Últimas fotos";
$LANG['summary']['nophotos']   = "No hay fotos en este momento";
$LANG['summary']['lastblog']   = "Últimas entradas en el blog";
$LANG['summary']['noentries']  = "No hay entradas en este momento";
$LANG['summary']['lastwiki']   = "Últimas entradas en el wiki";
$LANG['summary']['lastlinks']  = "Últimos enlaces";
$LANG['summary']['nolinks']    = "No hay enlaces en este momento";
$LANG['summary']['lastforum']  = "Últimos mensajes en el foro";
$LANG['summary']['noforum']    = "No hay mensajes en este momento";

# Header
# ------------------------------------------------------------------------------
$LANG['header']['language']     = "Idioma:";
$LANG['header']['enteryourpacs'] = "Entrar en Yourpacs";
$LANG['header']['welcome']      = "Bienvenido";
$LANG['header']['newaccount']   = "Registrarse";
$LANG['header']['haveaccount']  = "Entrar";
$LANG['header']['disconnect']   = "Desconectar";
$LANG['header']['sentfriend']   = "Quiero recomendar Yourpacs a un amigo";
$LANG['header']['gotocpanel']   = "Panel de control";

# Footer
# ------------------------------------------------------------------------------
$LANG['footer']['license'] = "Términos y condiciones";
$LANG['footer']['copy']    = " :: Yourpacs - 2010 ::";
$LANG['footer']['info']    = "";

# Section: Home
# ------------------------------------------------------------------------------
$LANG['home']['pagetitle']  = "Yourpacs :: Tu propio PACS en internet";
$LANG['home']['starttitle'] = "Tu propio PACS en internet";
$LANG['home']['startdesc']  = "<br/>   
                               Con <strong>YourPACS</strong> los profesionales del diagnóstico por la imágen podréis trabajar con
vuestra imágen médica, desde cualquier  lugar. <br/> <br/>
<img style='margin-left: 50px' src='/img/portada.png' HEIGHT='275', WIDTH='359' align='middle' />
<br/><br/>
A qué esperas? <a href='/es/newaccount'>Registrate</a> y empieza a disfrutar del primer pacs en la
nube!
";
$LANG['home']['enddesc']    = "<strong>Escr</strong>";
$LANG['home']['createtitle'] = "Crea tu cuenta en sólo 10 segundos";
$LANG['home']['onestep']     = "Elige un nombre";
$LANG['home']['twostep']     = "Elige una temática";
$LANG['home']['threestep']   = "Pulsa \"aceptar\"";
$LANG['home']['arrowcreate'] = "Crea tu cuenta ahora!";
$LANG['home']['randomusers'] = "Últimos usuarios";
$LANG['home']['lastposts']   = "Algunas entradas en los Blogs";

# Section: Login
# ------------------------------------------------------------------------------
$LANG['login']['pagetitle'] = "Yourpacs :: Entrar";
$LANG['login']['error1']    = "Nombre o contraseña incorrecta";

$LANG['login']['enterl']        = "Entrar en Yourpacs";
$LANG['login']['recoverpass']   = "Recuperar contraseña";
$LANG['login']['sentcode']      = "Se ha enviado un código de cambio de contraseña al correo";
$LANG['login']['emailnoexists'] = "La dirección de e-Mail no existe";
$LANG['login']['changepass']    = "Cambiar contraseña";
$LANG['login']['change']        = "Cambiar";


# Section: New account
# ------------------------------------------------------------------------------
$LANG['newaccount']['pagetitle']      = "Yourpacs :: Crear una cuenta";
$LANG['newaccount']['summary']        = "Crear una cuenta es muy sencillo.";
$LANG['newaccount']['onesteptitle']   = "Selecciona un nombre para la cuenta";
$LANG['newaccount']['twosteptitle']   = "Selecciona una temática para tus páginas";
$LANG['newaccount']['threesteptitle'] = "Pulsa el botón aceptar";

$LANG['newaccount']['desctitle'] = "Crear una cuenta en Yourpacs";
$LANG['newaccount']['desc']      = "Rellena el siguiente formulario con los datos solicitados y tendrás
									tu cuenta completamente funcional al instante. Todos los datos
									son obligatorios y <strong>recuerda</strong>: La dirección de correo electrónico es necesaria
									para enviarte los datos de tu cuenta y recuperar tu contraseña, así como para recibir
									anuncios de cambios en <strong>Yourpacs</strong>, mejoras e instrucciones para que puedas
									aprovecharte de las novedades. Así que te recomendamos que utilices una
									dirección de correo válida y que utilices habitualmente.";
$LANG['newaccount']['name']      = "Usuario";
$LANG['newaccount']['captcha']   = "Código de seguridad";
$LANG['newaccount']['verify']    = "Comprobar";
$LANG['newaccount']['email']     = $LANG['general']['email'];
$LANG['newaccount']['cemail']    = "Confirmar dirección de e-Mail";
$LANG['newaccount']['password']  = "Contraseña";
$LANG['newaccount']['cpassword'] = "Confirmar contraseña";
$LANG['newaccount']['acceptthe'] = "Acepto los";
$LANG['newaccount']['terms']     = "términos y condiciones";
$LANG['newaccount']['ofYourpacs'] = "de Yourpacs.";

$LANG['newaccount']['error'][0]  = "Es obligatoria";
$LANG['newaccount']['error'][1]  = "No coinciden";
$LANG['newaccount']['error'][2]  = "No es válida o no existe";
$LANG['newaccount']['error'][3]  = "6 carácteres como mínimo";
$LANG['newaccount']['error'][4]  = "No coinciden";
$LANG['newaccount']['error'][5]  = "Elige una temática";
$LANG['newaccount']['error'][6]  = "No has aceptado";

$LANG['newaccount']['maintetitle'] = "Tareas de mantenimiento";
$LANG['newaccount']['maintenance'] = "En estos momentos estamos realizando tareas
									  de mantenimiento y no es posible crear
									  nuevas cuentas.
									  <br/><br/>
									  Esta acción ha comenzado a las 19:00h
									  (GMT +1) y finalizará a las 21:00h (GMT +1).
									  <br/><br/>
									  Sentimos las molestias.";

# Section: Control panel
# ------------------------------------------------------------------------------
$LANG['controlpanel']['warning']          = "AVISO";
$LANG['controlpanel']['useradmin']        = "Usuario administrador:";
$LANG['controlpanel']['passadmin']        = "Contraseña administrador:";
$LANG['controlpanel']['wchangepassdesc1'] = "Se te ha asignado la contraseña";
$LANG['controlpanel']['wchangepassdesc2'] = "para que puedas acceder a tus páginas y configurarlas.
											 El usuario <strong>admin</strong> es el que utilizarás
											 para administrar tus páginas, a partir de sus propias
											 opciones. Te recomendamos que cambies la contraseña
											 lo antes posible desde el menú \"Configurar páginas\",
											 para poder acceder de forma sencilla y que recuerdes.";

$LANG['controlpanel']['pagetitle']     = "Yourpacs :: Panel de control";
$LANG['controlpanel']['desctitle']     = "Panel de control";
$LANG['controlpanel']['desc']          = "Empieza ya a utilizar el servicio! Para ello dirigete a nuestro <a href='http://www.yourpacs.com/wiki/'>wiki</a> donde encontrarás toda la información de
                                          como realizar la instalación y configuración de tu equipo.";
$LANG['controlpanel']['stilldemo']     = "Tu cuenta dispone de un periodo de prueba de un mes natural des de la fecha de registro: ";
$LANG['controlpanel']['stopdemo']      = "El periodo de prueba ha terminado!";
$LANG['controlpanel']['menu']          = "Menú";
$LANG['controlpanel']['home']          = "Principal";
$LANG['controlpanel']['configYourpacs'] = "Configurar Yourpacs";
$LANG['controlpanel']['configwebs']    = "Configurar páginas";
$LANG['controlpanel']['configdomain']  = "Configurar dominio";
$LANG['controlpanel']['installsoft']   = "Instalar / Desinstalar";
$LANG['controlpanel']['startweb']      = "Página de inicio";
$LANG['controlpanel']['logaccess']     = "Registro de eventos";
$LANG['controlpanel']['freespace']     = "Espacio libre";
$LANG['controlpanel']['using']         = "Estoy usando";
$LANG['controlpanel']['available']     = "disponibles";
$LANG['controlpanel']['mydataccount']  = "Datos de mi cuenta";
$LANG['controlpanel']['name']          = "Nombre:";
$LANG['controlpanel']['email']         = "e-Mail:";
$LANG['controlpanel']['dateadded']     = "Fecha de alta:";
$LANG['controlpanel']['urlhome']       = "Url principal:";
$LANG['controlpanel']['titleaccess']   = "Registro de los últimos eventos";
$LANG['controlpanel']['nologaccess']   = "No se han hecho cambios";
$LANG['controlpanel']['upgradeaccount']   = "Actualiza tu cuenta a Yourpacs PRO!";
$LANG['controlpanel']['upgradeaccountdesc']   = "Si actualizas tu cuenta, podrás empezar a disfrutar de tu própio PACS!
                                                 Consulta que ventajas tiene una cuenta <a href='/es/help/yourpacspro'>Yourpacs PRO</a>, y que puedes llegar
                                                 a <a href='/es/help/sothat'>hacer</a> con ella.";
$LANG['controlpanel']['titlepayments'] = "Últimos pagos";
$LANG['controlpanel']['downgradeaccount']  = "Elimina tu cuenta Yourpacs PRO!";
$LANG['controlpanel']['downgradeaccountdesc']   = "Si no quiere seguir suscrito con nosotros, puede eliminar su cuenta en cualquier momento.";
$LANG['controlpanel']['upgradetitle']  = "Actualiza tu cuenta a Yourpacs PRO!";
$LANG['controlpanel']['upgradedesc']   = "Actualiza tu cuenta y empieza a utilizar tu própio PACS desde el primer momento.";
$LANG['controlpanel']['nopayments']    = "No se han hecho pagos";
$LANG['controlpanel']['myblog']        = "mi blog";
$LANG['controlpanel']['myweb']         = "mi web";
$LANG['controlpanel']['mywiki']        = "mi wiki";
$LANG['controlpanel']['mylinks']       = "mis links";
$LANG['controlpanel']['myalbum']       = "mi álbum";
$LANG['controlpanel']['myforum']       = "mi foro";
$LANG['controlpanel']['samepass']      = "No puede ser la misma que la cuenta de Yourpacs";
$LANG['controlpanel']['shortpass']     = "Es demasiado corta";

$LANG['controlpanel']['mypagesdata']         = "Datos de mis páginas";
$LANG['controlpanel']['mypagesdatadesc']     = "Puedes acceder a tus páginas desde las siguientes direcciones:";
$LANG['controlpanel']['configaccount']       = "Configuración de la cuenta";
$LANG['controlpanel']['configallpages']      = "Configuración de mis páginas";
$LANG['controlpanel']['configallpagesdesc']  = "Con esta opción puedes cambiar la contraseña del usuario \"<strong>admin</strong>\" de todas tus páginas de una sola vez.";
$LANG['controlpanel']['cadminpasswdsuc']     = "Contraseña cambiada";
$LANG['controlpanel']['configwiki']          = "Configuración del Wiki";
$LANG['controlpanel']['configwordpress']     = "Configuración del Blog";
$LANG['controlpanel']['configwikititle']     = "Título:";
$LANG['controlpanel']['configwikiurl']       = "Url del logo:";
$LANG['controlpanel']['configwikilang']      = "Idioma:";
$LANG['controlpanel']['configwikitheme']     = "Tema:";
$LANG['controlpanel']['selectstartpage']     = "Seleccionar la página de inicio";
$LANG['controlpanel']['selectstartpagedesc'] = "Puedes usar como página de inicio un resumen de tus entradas o
												utilizar directamente una de tus páginas.";
$LANG['controlpanel']['configsuccess']       = "Cambios guardados";
$LANG['controlpanel']['configstats']         = "Cambiar contraseña de Stats";
$LANG['controlpanel']['configstatspasswd']   = "Contraseña:";
$LANG['controlpanel']['statspasswdsuccess']  = "Contraseña cambiada";

$LANG['controlpanel']['installsofttitle']      = "Instalar o desinstalar software";
$LANG['controlpanel']['installsoftdesc']       = "<strong>IMPORTANTE:</strong> Al desinstalar un software, la configuración y todo su contenido se perderá y la próxima vez que lo instales tendrás uno por defecto.
												  También te recomendamos que te asegures que tienes el espacio suficiente para poder instalar el software (20MBytes libres por cada uno) antes de realizar la acción.";
$LANG['controlpanel']['installsofterror1']     = "No puedes desinstalarlos todos";
$LANG['controlpanel']['installsofterror2']     = "No has marcado la casilla de confirmación";
$LANG['controlpanel']['installsoftsuccess']    = "Cambios guardados.";
$LANG['controlpanel']['installsoftcheck']      = "Estoy seguro de estos cambios";
$LANG['controlpanel']['installsoftconfirm']    = "Al desinstalar un software, la configuración y todo su contenido se perderá, ¿estás seguro?";
$LANG['controlpanel']['installsoftcheckerror'] = "Tienes que marcar la casilla de confirmación para poder hacer los cambios.";
$LANG['controlpanel']['domain']                = "Dominio:";
$LANG['controlpanel']['configdomaintitle']     = "Configurar un dominio";
$LANG['controlpanel']['configdomaindesc']      = "Desde aquí puedes configurar tu propio dominio para usarlo en Yourpacs.
												  Para poder hacerlo, asegurate que tu dominio apunta a la dirección";
$LANG['controlpanel']['configdomainconfirm']   = "¿Estás seguro que deseas eliminar el dominio?";
$LANG['controlpanel']['success']               = "Dominio configurado correctamente";
$LANG['controlpanel']['success2']              = "Dominio eliminado correctamente";
$LANG['controlpanel']['error1']                = "No es un dominio válido";
$LANG['controlpanel']['error2']                = "El dominio no está bien redireccionado";
$LANG['controlpanel']['deletedomain']          = "Eliminar dominio";
$LANG['controlpanel']['newsmail']              = "Informarme por e-Mail de las novedades y actualizaciones";
$LANG['controlpanel']['restorewp']             = "Restaurar:";
$LANG['controlpanel']['restorewpdesc']         = "<i>(Desactiva todos los plugins y pone el theme por defecto)</i>";
$LANG['controlpanel']['confirmrestorewp']      = "Esta opción, desactiva todos los plugins y pone el theme por defecto de Yourpacs. Desde el panel de control de tu Blog podrás volver a activar los plugins y ponerte el theme que quieras. ¿Estas seguro?";

$LANG['controlpanel']['pacs']      = "PACS";
$LANG['controlpanel']['payments']      = "Pagos";
$LANG['controlpanel']['search']      = "Búsqueda de usuarios";
$LANG['controlpanel']['invitation']      = "Invitar a un amigo";
$LANG['controlpanel']['documentation']      = "Documentación";

# Section: Help
# ------------------------------------------------------------------------------
$LANG['help']['alltitle']  = "Yourpacs :: Ayuda";
$LANG['help']['pagetitle'] = "Yourpacs :: ";

# Section: Verify Account
# ------------------------------------------------------------------------------
$LANG['verifyaccount']['error1'] = "Es demasiado corto";
$LANG['verifyaccount']['error2'] = "Sólo puede tener números y letras";
$LANG['verifyaccount']['error3'] = "Ya está en uso";
$LANG['verifyaccount']['error4'] = "No es válido";
$LANG['verifyaccount']['error5'] = "Código incorrecto";

# Section: Contact
# ------------------------------------------------------------------------------
$LANG['contact']['title']   = "Contactar con Yourpacs";
$LANG['contact']['desc']    = "Si quieres contactar con el equipo de Yourpacs, rellena el siguiente formulario.";
$LANG['contact']['email']   =  $LANG['general']['email'];
$LANG['contact']['message'] = "Mensaje";
$LANG['contact']['error1']  = "No es válido";
$LANG['contact']['error2']  = "Es demasiado corto";
$LANG['contact']['success'] = "Mensaje enviado con éxito.<br/>En breve nos pondremos
							   en contacto contigo y responderemos a tu mensaje";
$LANG['contact']['text_new'] = "Si tienes alguna duda o problema con <b>Yourpacs</b>, no dudes en consultar nuestro <a href='http://www.yourpacs.com/wiki/'>Wiki</a>.<br/><br/>";

# Section: Invitation
#
$LANG['invitation']['title'] = "Invita a un amigo";
$LANG['invitation']['desc'] = "Introduce aquí el correo de alguien a quien quieras enviar una invitación para entrar en YourPACS, y nosotros se la mandamos.";
$LANG['invitation']['success'] = "Mensaje enviado con éxito.";

# Section: Searchuser
#
$LANG['searchuser']['title'] = "Buscar usuario";
$LANG['searchuser']['desc'] = "En el siguiente recuadro puedes introducir el nombre de un usuario YourPACS PRO (o parte de él) o un email para saber si el usuario existe, y en dicho caso, los datos de su pacs.";
$LANG['searchuser']['user'] = "Usuario";
$LANG['searchuser']['aet'] = "Aetitle del pacs";
$LANG['searchuser']['ip'] = "Dirección IP";
$LANG['searchuser']['port'] = "Puerto";
$LANG['searchuser']['notfound'] = "No se han encontrado usuarios";

# Section: Pacs
#
$LANG['pacs']['title'] = "Tu PACS";
$LANG['pacs']['desc_free'] = "A continuación tienes los datos que debes utilizar para enviar estudios a un PACS de YourPACS. Puedes utilizar la <a href='/es/controlpanel/searchuser'>búsqueda de usuarios</a> para obtener los datos de configuración
                        del PACS del usuario al que quieras enviar.";
$LANG['pacs']['desc_pro'] = "A continuación tienes los datos que debes utilizar para configurar tu visor. Tanto los datos del propio visor, como los de tu nodo PACS.";
$LANG['pacs']['aet'] = "Aetitle:";
$LANG['pacs']['ip'] = "Dirección IP:";
$LANG['pacs']['port'] = "Puerto:";
$LANG['pacs']['client'] = "Datos para tu visor";
$LANG['pacs']['server'] = "Datos de tu PACS";

# Section: Studies
#
$LANG['studies']['title'] = "Listado de estudios";
$LANG['studies']['patientname'] = "Nombre";
$LANG['studies']['studytype'] = "Modalidad";
$LANG['studies']['studydesc'] = "Descripción";
$LANG['studies']['studydate'] = "Fecha";

# Section: Recoverpass
# ------------------------------------------------------------------------------
$LANG['recoverpass']['pagetitle']     = "Yourpacs :: Recuperar contraseña";
$LANG['recoverpass']['codenovalid']   = "El código de cambio de contraseña no es válido.";
$LANG['recoverpass']['codechanged']   = "El código de cambio de contraseña a caducado.";
$LANG['recoverpass']['notexists']     = "No existe";
$LANG['recoverpass']['tooshort']      = "Demasiado corta";
$LANG['recoverpass']['notsame']       = "No coinciden";
$LANG['recoverpass']['codeincorrect'] = "El código no se corresponde con la cuenta";
$LANG['recoverpass']['codenotexists'] = "El código de cambio de contraseña no existe.";

# Section: Userlist
# ------------------------------------------------------------------------------
$LANG['userlist']['pagetitle'] = "Yourpacs :: Directorio de usuarios";
$LANG['userlist']['title']     = "Directorio de usuarios";
$LANG['userlist']['desc']      = "Aquí podrás ver un listado organizado por <strong>temáticas</strong> de los usuarios
								  de <strong>Yourpacs</strong> que han escrito más de una entrada en su Blog.
								  Para salir en el directorio, sólo tienes que comenzar a escribir en el tuyo.";
