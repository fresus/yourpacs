<?php

require_once("../lib/html_mime_mail_2.5/htmlMimeMail.php");

$es_subjhtml = "Ya puedes crear tu pagina web con Joomla";
$es_bodyhtml = "
<h1>Ya puedes crear tu página web con Joomla!</h1>
<p>
Desde ahora, puedes instalar un nuevo software, <b>Joomla! 1.5 beta 2</b>,
un CMS preparado para crear una página web en toda regla, con sus encuestas,
gestor de descargas, publicación de noticias, y un sin fin de cosas más.
<br><br>
Para poder usarlo, te informamos que hemos activado la opción de <b>instalar y/o
desinstalar</b> todos los softwares de Yourpacs. Con la sencillez de siempre, únicamente
tienes que marcar el software deseado, confirmar y aceptar en tu panel de control.
<br><br>
También está disponible desde '<i>Configurar páginas'</i>, la opción de
restaurar el Blog. Si después de instalar un theme o activar un plugin tu Blog
deja de funcionar, con esta opción puedes recuperarlo fácilmente, y sin
perder ningún contenido.
<br/><br/>

Recuerda que como prometimos, dentro de muy poco habrán más novedades, algunas
de ellas serán:
<ul>
   <li>Nuevo software disponible: <a href=\"http://moodle.org/\">Moodle</a>, para enseñar todo lo que sabes.</li>
   <li>Mejoras, plugins y más themes para tu Foro.</li>
</ul>

<br/><br/>
Te damos las gracias por confiar en Yourpacs, y esperamos que todas estas novedades te gusten.<br/>
Recuerda que puedes leer todas las novedades en el <a href=\"http://blog.lynksee.com\">Blog oficial de Yourpacs</a>.<br/>
Si no quieres recibir más correos como este, puedes configurarlo en tu panel de control.<br/>
--<br/>
Yourpacs support
</p>
";

$ca_subjhtml = "Ja pots crear la teva pagina web amb Joomla";
$ca_bodyhtml = "
<h1>Ja pots crear la teva pàgina web amb Joomla!</h1>
<p>
Des d'ara, pots instal·lar un nou software, <b>Joomla! 1.5 beta 2</b>,
un CMS preparat per crear una pàgina web de d'alt a baix, amb els seus qüestionaris,
gestor de descarregues, publicació de notícies, i moltes coses més.
<br><br>
Per a poder utilitzar-ho, t'informem que hem activat l'opció de <b>instal·lar i/o
desinstal·lar</b> tots els softwares de Yourpacs. Amb la mateixa facilitat de sempre, únicament
hauràs de marcar el software desitjat, confirmar i acceptar en el teu panell de control.
<br><br>
També està disponible des de '<i>Configurar pàgines'</i>, l'opció de
restaurar el Blog. Si després d'instal·lar un theme o activar un plugin el teu Blog
deixa de funcionar, amb aquesta opció podràs recuperar-lo fàcilment, i sense
perdre cap contingut.
<br/><br/>

Recorda que com vam prometre, dintre de poc hi hauran més novetats, algunes
d'aquestes seran:
<ul>
    <li>Nou software disponible: <a href=\"http://moodle.org/\">Moodle</a>, per ensenyar tot el que saps.</li>
    <li>Millores, plugins i més themes per al teu Forum.</li>
</ul>

<br/><br/>
Et donem les gràcies per confiar en Yourpacs, i esperem que totes aquestes novetats t'agradin.<br/>
Recorda que pots llegir totes les novetats al <a href=\"http://blog.lynksee.com\">Blog oficial de Yourpacs</a>.<br/>
Si no vols rebre més correus com aquest, pots configurar-ho al teu panell de control.<br/>
--<br/>
Yourpacs support
</p>
";

$en_subjhtml = "Now, you can create your Web page with Joomla";
$en_bodyhtml ="
<h1>Now, you can create your Web page with Joomla!</h1>
<p>
Since now, you can install a new software, <b>Joomla! 1.5 beta 2</b>,
a CMS prepared for create a web page with their questionaires,
download manager, news publication, and more things.
<br><br>
We have added a new option for <b>install and/or
uninstall</b> all the Yourpacs softwares. You only will have to mark the wished software, and confirm the action in your control panel.
<br><br>
You can restore yor default blog setting in the '<i>Config webs'</i> option, on your control panel. If your Blog stops working after installing a new theme or a new plugin, with this option you will be able to solve it easily, and without lose any contents.
<br/><br/>

Remember that as we promise, in a short time, you will have:
<ul>
<li>New software: <A href=\"http://moodle.org/\">Moodle</a>, to teach every that you know.</li>
<li>Improvements, plugins and more themes for the your Forum.</li>
</ul>

<br/><br/>
We thank you for trusting on Yourpacs, and we wait that you like all these news.<br/>
Remember that you can read all the news in the official <a href=\"http://blog.lynksee.com\">Yourpacs Blog</a>.<br/>
If you do not want to receive more emails, you can configure it on your control panel.<br/>
--<br/>
Yourpacs support
</p>
";



$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");

$rs = mysql_query("SELECT * FROM account WHERE newsmail = 1 AND id_account > 43 ORDER BY id_account ASC", $conn);
while ($data = mysql_fetch_assoc($rs))
{
	if ($data['id_lang'] == 1) {
		$subject = $es_subjhtml;
		$body    = $es_bodyhtml;
	}
	else if($data['id_lang'] == 3) {
		$subject = $ca_subjhtml;
		$body    = $ca_bodyhtml;
	}
	else if($data['id_lang'] == 2 || $data['id_lang'] == 5) {
		$subject = $en_subjhtml;
		$body    = $en_bodyhtml;
	}
	else {
		$subject = $es_subjhtml;
		$body    = $es_bodyhtml;
	}

	$mail = new htmlMimeMail();
	$mail->setHtml(utf8_decode($body), null);
	$mail->setReturnPath('support@lynksee.com');
	$mail->setFrom('"Yourpacs" <support@lynksee.com>');
	$mail->setSubject(utf8_decode($subject));
	$mail->setHeader('X-Mailer', 'Yourpacs mailer v1 (http://www.lynksee.com)');
	$mail->setHeader('Message-ID', '<jg2nnp.rkio1@>');
	$mail->setHeader('Content-type', 'text/html; charset="UTF-8"');
	$result = $mail->send(array($data['email']), 'mail');

	if (!$result) {
		print_r($mail->errors);
	} else {
		echo "e-Mail enviado a {$data['email']}\n";
	}

	sleep(2);
}