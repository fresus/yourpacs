<?php
/**
Section: Login
@file login.class.php
@class Login
@version 1.0
@date 17 de marzo del 2007
@author Macos Julian <marcos@lynksee.com>

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

class Login extends Section
{
	/** ************************************************************************
	* Constructor
	*    - @param section string (Nombre de la seccion)
	***************************************************************************/
	function __construct($section = null)
	{
		parent::__construct($section);

		if (User::getCurrentUser())
		{
			if ($_GET['disconnect'] == "true")
			{
				unset($_SESSION['account']);
				header("Location: /" . Lang::$acronym);
				exit();
			}
			else
			{
				header("Location: /" . Lang::$acronym . "/controlpanel");
				exit();
			}
		}
	}

	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		Config::set("page", "title", Lang::get("login", "pagetitle"));

		# Datos
		if (isset($_POST['account']) && isset($_POST['passwd']))
		{
			Db::query("SELECT * FROM account WHERE login = %s AND pass = %s", array(strtolower(trim($_POST['account'])), trim($_POST['passwd'])));
			if ($data = Db::resultOne())
			{
				$_SESSION['account'] = md5($data['id_account']);
				header("Location: /" . Lang::$acronym . "/controlpanel");
				exit();
			}
			else
			{
				$this->doc->appendNode("account", $_POST['account'], array("class" => "error", "error" => Lang::get("login", "error1")));
				$this->doc->appendNode("passwd", null, array("class" => "text"));
			}
		}
		else
		{
			$this->doc->appendNode("account", null, array("class" => "text"));
			$this->doc->appendNode("passwd", null, array("class" => "text"));
		}

		# Recuperar contraseña
		if (isset($_POST['email']))
		{
			Db::query("SELECT * FROM account WHERE email = %s", array(strtolower(trim($_POST['email']))));
			if ($data = Db::resultOne())
			{
				$this->recoverPass($data['id_account'], $data['login'], $data['email']);
				$this->doc->appendNode("success", 1);
			}
			else
			{
				$this->doc->appendNode("email", $_POST['email']);
				$this->doc->appendNode("error", 1);
			}
		}

		return $this->show();
	}

	function recoverPass($id, $login, $email)
	{
		# Init
		$sha1 = sha1(rand(0, 999) . date("Y-m-d H:i:s"));
		$hash = substr($sha1, 0, 12);
		$url  = "http://www.lynksee.com/" . Lang::$acronym . "/recoverpass/{$hash}";
		$subj = Lang::get("email", "rpsubject");
		$body = Lang::get("email", "rpbody");

		# Enviamos el mail con los datos
		$headers  = "From: Yourpacs <support@lynksee.com>\n";
		$headers .= "Reply-To: Yourpacs <support@lynksee.com>\n";
		$headers .= "Return-Path: Yourpacs <support@lynksee.com>\n";
		$headers .= "X-Mailer: PHP v".phpversion()."\n";
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
		$headers .= "MIME-Version: 1.0\n\n";

		# Remplazamos la URL
		$body = str_replace("[%LOGIN%]", $login, $body);
		$body = str_replace("[%EMAIL%]", $email, $body);
		$body = str_replace("[%URL%]", $url, $body);

		# Enviamos el mail
		mail($email, $subj, $body, $headers);

		# Invalidamos los codigos de cambio anteriores
		Db::query("UPDATE account_changepass SET valid = 0 WHERE id_account = %i", array($id));

		# Añadimos el nuevo código
		Db::query("INSERT INTO account_changepass (id_account, date, hash, valid, used) VALUES (%i, NOW(), %s, 1, 0)", array($id, $hash));
	}
}
