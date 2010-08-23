<?php

$conn = mysql_pconnect("localhost", "website", "EeJaesie4pie");
mysql_select_db("website");
mysql_query("SET NAMES `utf8`");

require_once("../mainsite/lib/html_mime_mail_2.5/htmlMimeMail.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
<meta http-equiv="content-type" content="text/xml; charset=utf-8" />
<style>* {font-size: 11px; font-family: Verdana, arial;}</style>
</head>
<body>

	<?php
	if ((int)$_GET['reply'])
	{
		$rs   = mysql_query("SELECT contact.*, account.login FROM contact LEFT JOIN account ON account.id_account = contact.id_user WHERE id = {$_GET['reply']}", $conn);
		$data = mysql_fetch_assoc($rs);
		?>
		<div style="border: 1px solid grey; overflow: auto; height: 200px; width: 600px; margin: 0 auto;"><?= nl2br($data['text']) ?></div>
		<form name="form" action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post">
			<input type="hidden" name="id" value="<?= $data['id'] ?>" />
			<input type="hidden" name="email" value="<?= $data['email'] ?>" />
			<br/>
			<div style="text-align: center;">Login: <span style="font-weight: bold; font-size: 12px;"><?= $data['login'] ? $data['login'] : "Usuario ANONIMO" ?></span></div>
			<div style="text-align: center;">Asunto: <input type="text" name="subject" value="" style="width: 400px;"/></div>
			<div style="text-align: center;">
<textarea style="white-space: pre; width: 600px; height: 200px;" name="respuesta">

--
  Yourpacs Support</textarea>
			</div>
			<div style="text-align: center;"><input type="submit" value="Responder" style="padding: 4px 10px 4px 10px;" /></div>
		</form>
		<?php
	}
	?>

	<?php
	if ($_POST['id'] && $_POST['email'] && $_POST['respuesta'] && $_POST['subject'])
	{
		$subject = trim($_POST['subject']);
		$html  = nl2br($_POST['respuesta']);
		$text  = $_POST['respuesta'];
		$email = trim($_POST['email']);

		$mail = new htmlMimeMail();
		$mail->setText($text);
		$mail->setReturnPath('support@yourpacs.com');
		$mail->setFrom('"Yourpacs" <support@yourpacs.com>');
		$mail->setSubject($subject);
		$mail->setHeader('X-Mailer', 'Yourpacs Mailer (http://www.yourpacs.com)');
		$mail->setHeader('Message-ID', '<jg2nnp.rkio1@>');
		$result = $mail->send(array($email, 'support@yourpacs.com'), 'smtp');

		mysql_query("UPDATE contact SET reply = 1 WHERE id = {$_POST['id']}");

		?><span style="color: green;">Email enviado a <?= $_POST['email'] ?></span><?php
	}
	else if(isset($_POST['id']) && (empty($_POST['id']) || empty($_POST['email']) || empty($_POST['respuesta']) || empty($_POST['subject'])))
	{
		?><span style="color: red;">Error al enviar el mensaje, faltan datos</span><?php
	}
	?>

<br/><br/>
<table width="100%" cellpadding="2" cellspacing="0" border="1">
<tr>
	<td><strong>Login</strong></td>
	<td><strong>e-Mail</strong></td>
	<td><strong>Resum</strong></td>
	<td><strong>Respost</strong></td>
	<td><strong>Opcions</strong></td>
</tr>
<?php

$rs = mysql_query("SELECT contact.*, account.login FROM contact LEFT JOIN account ON account.id_account = contact.id_user ORDER BY date DESC", $conn);
while ($data = mysql_fetch_assoc($rs))
{
	$style = $data['reply'] ? "style='background-color: #B2FF9F;'" : "null";
	?>
	<tr>
		<td <?= $style ?>><?= $data['login'] ? $data['login'] : "Anònim" ?></td>
		<td <?= $style ?>><?= $data['email'] ?></td>
		<td <?= $style ?>><?= substr($data['text'], 0, 85) ?></td>
		<td <?= $style ?>><?= $data['reply'] ? "Si" : "No" ?></td>
		<td <?= $style ?>><a href="?reply=<?= $data['id'] ?>">Respondre</a></td>
	</tr>
	<?php
}
?>
</table>
</body>
</html>
<?php
