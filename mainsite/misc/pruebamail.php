<?php

require_once("../lib/html_mime_mail_2.5/htmlMimeMail.php");

$mail = new htmlMimeMail();
$mail->setHtml("prueba prueba support@lynksee.com", "prueba prueba");
$mail->setReturnPath('support@lynksee.com');
$mail->setFrom('"Yourpacs" <support@lynksee.com>');
$mail->setSubject('Test mail');
$mail->setHeader('X-Mailer', 'Yourpacs mailer v1 (http://www.lynksee.com)');
$mail->setHeader('Message-ID', '<jg2nnp.rkio1@>');
$result = $mail->send(array('albert.sellares@gmail.com'), 'smtp');

if (!$result) {
	print_r($mail->errors);
} else {
	echo 'e-Mail enviado';
}
