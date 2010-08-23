<?php
/**
Section: Create Account
@file createaccount.class.php
@class Createaccount
@version 1.0
@date 7 de marzo del 2007
@author Marcos Julian <marcos@lynksee.com>

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

class Createaccount extends Section
{
	/** ************************************************************************
	* Constructor
	*    - @param section string (Nombre de la seccion)
	***************************************************************************/
	function __construct($section = null)
	{
		parent::__construct($section);

		# Controles
		if (User::getCurrentUser()) {
			header("Location: /" . Lang::$acronym . "/controlpanel");
			exit();
		}

		# Comprobamos los datos
		$login  = trim($_POST['account']);

		# Eliminamos los acentos y dieresis en los nombres
		$login = strtr($login, "àèìòùáéíóúäëïüöâêîôûçñ", "aeiouaeiouaeiouaeioucn");

		# Eliminamos los acentos y dieresis en los nombres
		$login = strtr($login, "ÀÈÌÒÙÁÉÍÓÚÄËÏÖÜÂÊÎÔÛÇÑ", "AEIOUAEIOUAEIOUAEIOUCN");

		$login  = strtolower($login);
		$email  = strtolower(trim($_POST['email']));
		$passwd = trim($_POST['passwd']);
		//$category = (int)$_POST['thematic'];
		//$thematic = (int)$_POST['thematicvalue'];
		$terms    = (int)$_POST['acceptterms'];

		# Miramos que existan todos los datos
		if (!$login || !$email || !$passwd || !$terms) {
			$this->error();
		}

		# Miramos si las contraseñas coinciden
		if ($_POST['passwd'] != $_POST['cpasswd']) {
			$this->error();
		}

		# Miramos si los emails coinciden
		if ($_POST['email'] != $_POST['cemail']) {
			$this->error();
		}

		# Miramos si el login tiene 4 o mas caracteres
		if (strlen($login) < 4) {
			$this->error();
		}

		# Miramos que el login sea correcto
		if (!ereg("^[a-z]{1}[a-z0-9\-_]{2,14}[a-z0-9]{1}$", $login)) {
			$this->error();
		}

		# Miramos si la contraseña tiene menos de 6 caracteres
		if (strlen($passwd) < 6) {
			$this->error();
		}

		# Miramos si el email es valido
		if(!eregi("^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~]+\\.)+[a-zA-Z]{2,6}\$", $email)) {
			$this->error();
		}

		# Miramos si tenemos que ignorar el captcha
		if ($_POST['ignorecaptcha'] != 1)
		{
			# Miramos el codigo de captcha
			if ($_SESSION['captcha'] != $_POST['captcha']) {
				$this->error();
			}
		}

		# Miramos si existe la tematica seleccionada
		#Db::query("SELECT * FROM thematic WHERE id_thematic = %i", array($thematic));
		#if (!Db::resultOne()) {
		#	$this->error();
		#}

		# Miramos si ya existe el Login o el Email
		Db::query("SELECT * FROM account WHERE login = %s OR email = %s", array($login, $email));
		if (Db::resultOne()) {
			$this->error();
		}

		# Miramos si el login esta en la blacklist
		Db::query("SELECT * FROM blacklist WHERE login = %s", array($login));
		if (Db::resultOne()) {
			$this->error();
		}

		# Generamos 2 hash aleatorios
		#while ($hash = $this->generateHash())
		#{
		#	Db::query("SELECT * FROM account WHERE dir1 = %s AND dir2 = %s", array($hash[0], $hash[1]));
		#	if (!Db::resultOne()) {
		#		break;
		#	}

		#	if ($count++ >= 100) exit();
		#}

		# Añadimos el usuario
		$sql = "INSERT INTO account
				(id_realm, login, pass, email, date)
				VALUES
				(1, %s, %s, %s, NOW())";
		Db::query($sql, array($login, $passwd, $email));
		$id = Db::id();

        Dcm4chee::createIps($id, $login);


        Dcm4chee::addUser($login, Dcm4chee::$result);

		# Creamos la conexion y el software
		#Connect::command("create {$login} {$email} {$hash[0]} {$hash[1]}");

		# Asignamos una contraseña aleatoria para el software
		#$sha1    = sha1(rand(0, 9999) . microtime());
		#$newpass = substr($sha1, 0, 6);

		# Enviamos el mail con los datos
		$headers  = "From: Yourpacs <support@yourpacs.com>\n";
		$headers .= "Reply-To: Yourpacs <support@yourpacs.com>\n";
		$headers .= "Return-Path: Yourpacs <support@yourpacs.com>\n";    // these two to set reply address
		$headers .= "X-Mailer: PHP v".phpversion()."\n";          // These two to help avoid spam-filters
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
		$headers .= "MIME-Version: 1.0\n\n";

		$body = str_replace("[%LOGIN%]", $login, Lang::get("email", "nabody"));
		$body = str_replace("[%PASSWD%]", $passwd, $body);
		$body = str_replace("[%ADMINPASSWD%]", $newpass, $body);

		mail($email, Lang::get("email", "nasubject"), $body, $headers);

		# Asignamos una contraseña aleatoria para el software
		#Db::query("UPDATE account SET defaultpass = %s WHERE id_account = %i", array($newpass, $id));
		#Db::query("INSERT INTO account_stats (id_account, passwd) VALUES (%i, %s)", array($id, md5($newpass)));

		# Llenamos la base de datos con el software
		#Db::query("INSERT INTO account_software (id_account, id_software, date) VALUES (%i, %i, %d)", array($id, 1, date("Y-m-d H:i:s")));
		#Db::query("INSERT INTO account_software (id_account, id_software, date) VALUES (%i, %i, %d)", array($id, 2, date("Y-m-d H:i:s")));
		#Db::query("INSERT INTO account_software (id_account, id_software, date) VALUES (%i, %i, %d)", array($id, 3, date("Y-m-d H:i:s")));
		#Db::query("INSERT INTO account_software (id_account, id_software, date) VALUES (%i, %i, %d)", array($id, 4, date("Y-m-d H:i:s")));
		#Db::query("INSERT INTO account_software (id_account, id_software, date) VALUES (%i, %i, %d)", array($id, 5, date("Y-m-d H:i:s")));

		# Asignamos la contraseña aleatoria al software
		#$this->assingPassSoftware($login, $email, $newpass);

		# Nos vamos al panel de control
		$_SESSION['account'] = md5($id);
		header("Location: /" . Lang::$acronym . "/controlpanel");
		exit();
	}

	function perform()
	{
		return $this-show();
	}

	function error()
	{
		header("Location: /" . Lang::$acronym . "/newaccount");
		exit();
	}

	function assingPassSoftware($account, $email, $passwd)
	{
		# Seleccionamos la DB
		mysql_select_db($account);
		$pass    = md5($passwd);
		$gallery = $this->galleryPass($passwd);

		# Cambiamos el pass del wordpress
		Db::query("UPDATE wp_users SET user_pass = %s, user_email = %s WHERE user_login = 'admin'", array($pass, $email));
		Db::query("UPDATE wp_options SET option_value = %s WHERE option_name = 'admin_email'", array($email));
		Db::query("UPDATE wp_options SET option_value = %s WHERE option_name = 'siteurl'", array("http://{$account}.lynksee.com/blog"));
		Db::query("UPDATE wp_options SET option_value = %s WHERE option_name = 'home'", array("http://{$account}.lynksee.com/blog"));
		Db::query("UPDATE wp_options SET option_value = %s WHERE option_name = 'blogname'", array($account));

		# Cambiamos el pass del sabrosus
		Db::query("UPDATE sab_config SET admin_pass = %s, admin_email = %s, sabrosus_url = %s, site_url = %s", array($pass, $email, "http://{$account}.lynksee.com/links", "http://{$account}.lynksee.com"));

		# Cambiamos el pass del wiki
		Db::query("UPDATE wiki_user SET user_password = MD5(CONCAT(user_id,'-',%s)) WHERE user_name = 'Admin'", array($pass));

		# Cambiamos el pass del phpBB
		Db::query("UPDATE phpbb_users SET user_password = %s, user_email = %s WHERE username = 'admin'", array($pass, $email));
		Db::query("UPDATE phpbb_config SET config_value = %s WHERE config_name = %s", array("{$account}.lynksee.com", $account));
		Db::query("UPDATE phpbb_config SET config_value = %s WHERE config_name = 'sitename'", array("Forum {$account}"));
		Db::query("UPDATE phpbb_config SET config_value = %s WHERE config_name = 'server_name'", array("{$account}.lynksee.com"));
		Db::query("UPDATE phpbb_config SET config_value = %s WHERE config_name = 'board_email'", array($email));

		# Cambiamos el login del gallery
		Db::query("UPDATE g2_User SET g_hashedPassword = %s, g_email = %s WHERE g_userName = 'admin'", array($gallery, $email));
		Db::query("UPDATE g2_PluginParameterMap SET g_parameterValue = %s WHERE g_pluginType = 'module' AND g_pluginId = 'register' AND g_parameterName = 'from'", array($email));
		Connect::command("clean_gallery_cache {$account}");

		# Volvemos a la DB de Yourpacs
		mysql_select_db(Config::get("db", "dbname"));
	}

	function galleryPass($password, $salt='')
	{
		if (empty($salt))
		{
			for ($i = 0; $i < 4; $i++)
			{
				$char = mt_rand(48, 109);
				$char += ($char > 90) ? 13 : ($char > 57) ? 7 : 0;
				$salt .= chr($char);
			}
		}
		else
		{
			$salt = substr($salt, 0, 4);
		}
		return $salt . md5($salt . $password);
	}

	function generateHash()
	{
		$sha1 = sha1("bond, james bond :) " . rand(0,9999) . microtime());
		$sha2 = sha1("manolo, solo manolo :) " . rand(0,9999) . microtime());
		$sha1 = substr($sha1, 0, 10);
		$sha2 = substr($sha2, 0, 10);

		return array($sha1, $sha2);
	}
}
