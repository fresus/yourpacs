<?php

function writeLog($text)
{
	$fp   = fopen("/var/www/mainsite/misc/mailing_backup.txt", "a+");
	$date = date("Y-m-d H:i:s");

	fwrite($fp, "[{$date}] {$text}\n");
	fclose($fp);

	return true;
}

require_once("../lib/html_mime_mail_2.5/htmlMimeMail.php");
$subject  = "Yourpacs :: Backup de tu sitio";
$body_org = "
<html><head><title>Yourpacs :: Backup de tu sitio</title></head><body>
Hola [%LOGIN%],<br><br>
Como no queremos que nuestro viaje juntos acabe con un mal sabor de boca,
te hemos preparado un Backup con toda la información de tus páginas,
así como todas tus imágenes e información de la base de datos que podrás
descargar desde ahora hasta el día del cierre del proyecto.<br>
<a href=\"http://[%LOGIN%].lynksee.com/[%DIR%]/backup.tar.gz\">Descargar
Backup</a><br>
<br>
Te informamos que a partir de ahora, Yourpacs continuará desarrollando
software de código libre (no nos rendimos) y podrás seguir nuestro
avance en un nuevo <a href=\"http://www.lynksee.com\">Blog</a>
que hemos creado para la ocasión. En este mismo Blog hemos hecho un apartado
dedicado al proyecto llamado \"Cementerio de Yourpacs\" donde aparecen los logros
conseguidos y sus últimas voluntades. Si lo deseas, puedes pasarte a
echar un vistazo y firmar en su libro de recordatorio a modo de despedida.<br>
<br>
Como usuario de Yourpacs queremos que seas el primero en probar nuestro nuevo proyecto
libre, llamado <em>dgo!</em> que podrás encontrar en <a
href=\"http://www.dgospace.com\">http://www.dgospace.com</a>.
Hemos conseguido tenerlo listo antes del cierre definitivo para que
veas que seguimos aquí, poniendo nuestro granito de arena en esta gran montaña
de internet.<br>
<br>
No quisieramos despedirnos sin darte las gracias por haber formado
parte del proyecto Yourpacs y deseamos de todo corazón que sigas
confiando en nosotros y en proyectos que podamos hacer de ahora en
adelante.<br>
<br>
Un abrazo sincero,<br>
Equipo de Yourpacs.
</body></html>
";


$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");

$rs = mysql_query("SELECT * FROM account ORDER BY id_account ASC", $conn);
while ($data = mysql_fetch_assoc($rs))
{
	$body = $body_org;
	$body = str_replace("[%LOGIN%]", $data['login'], $body);
	$body = str_replace("[%DIR%]", $data['dir2'], $body);

	$mail = new htmlMimeMail();
	$mail->setHtml($body, null);
	$mail->setReturnPath('support@lynksee.com');
	$mail->setFrom('"Yourpacs" <support@lynksee.com>');
	$mail->setSubject($subject);
	$mail->setHeader('X-Mailer', 'Yourpacs mailer v1 (http://www.lynksee.com)');
	$mail->setHeader('Message-ID', "<" . rand(1000, 9999) . "." . rand(1000, 9999) . "@mail.lynksee.com>");
	$mail->setHeader('Content-type', 'text/html; charset="UTF-8"');
	$result = $mail->send(array($data['email']), 'mail');

	if (!$result) {
		writeLog(print_r($mail->errors, true));
	} else {
		writeLog("e-Mail enviado a ({$data['id_account']}) {$data['email']}");
	}

	sleep(1);
}
