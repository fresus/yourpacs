<?php

$conn = mysql_pconnect("localhost", "root", "pepitogrillo");
mysql_select_db("lynksee");
mysql_query("SET NAMES `utf8`");


# Enviamos el mail con los datos
$headers  = "From: Yourpacs <support@lynksee.com>\n";
$headers .= "Reply-To: Yourpacs <support@lynksee.com>\n";
$headers .= "Return-Path: Yourpacs <support@lynksee.com>\n";    // these two to set reply address
$headers .= "X-Mailer: PHP v".phpversion()."\n";          // These two to help avoid spam-filters
$headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
$headers .= "MIME-Version: 1.0\n\n";

$subject = "Yourpacs - Ya puedes instalar tus temas y plugins en tu Blog";

$body = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
		<html><head>
		<title>{$subject}</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		</head><body>
		Hola [%LOGIN%],<br/>
		<br/>
		Te notificamos que se acaba de añadir un plugin a tu Blog llamado
		WP-Installer que te permitirá desde ahora instalar nuevos temas y
		nuevos plugins.<br/>
		<br/>
		Para poder usarlo sólo tienes que activarlo desde el menú de Plugins
		de tu Blog y te aparecerán nuevas opciones que te permitirán de una
		manera rápida y sencilla instalar ese tema y ese plugin que tanto te
		gusta.<br/>
		<br/>
		Esperamos que te guste esta mejora.<br/>
		Un saludo.<br/>
		---<br/>
		http://www.lynksee.com<br/>
		support@lynksee.com
		</body></html>";

$rs = mysql_query("SELECT * FROM account WHERE id_account <= 789 ORDER BY id_account ASC", $conn);
while ($data = mysql_fetch_assoc($rs))
{
		$body2 = str_replace("[%LOGIN%]", $data['login'], $body);
		#mail($data['email'], $subject, $body2, $headers);

		echo "e-Mail enviado: {$data['email']} a las (" . date("d-m-Y H:i:s") . ")\n";
		sleep(2);
}
