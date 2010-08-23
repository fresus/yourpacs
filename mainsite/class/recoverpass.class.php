<?php
/**
Section: Recover Password
@file recoverpass.class.php
@class Recoverpass
@version 1.0
@date 28 de marzo del 2007
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

class Recoverpass extends Section
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
			header("Location: /" . Lang::$acronym . "/controlpanel");
			exit();
		}

		# Miramos que exista hash
		if (strlen($_REQUEST['hash']) < 12) {
			header("Location: /" . Lang::$acronym);
			exit();
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
		$error = false;
		Config::set("page", "title", Lang::get("recoverpass", "pagetitle"));

		# Comprobamos que el hash sea valido y no este caducado
		Db::query("SELECT * FROM account_changepass WHERE hash = %s", array($_REQUEST['hash']));
		if ($data = Db::resultOne())
		{
			# Miramos que sea valido
			if ($data['valid'] == 0) {
				$this->doc->appendNode("hasherror", Lang::get("recoverpass", "codenovalid"));
			}
			# Miramos que no este caducado
			else if (strtotime($data['date']) < time() - 1800) {
				$this->doc->appendNode("hasherror", Lang::get("recoverpass", "codechanged"));
			}
			else
			{
				$this->doc->appendNode("hasherror", 0);

				# Datos
				if ($_POST['hash'] && $_POST['account'] && $_POST['passwd'] && $_POST['cpasswd'])
				{
					# Miramos si la cuenta existe
					Db::query("SELECT * FROM account WHERE login = %s", array(strtolower(trim($_POST['account']))));
					if (Db::resultOne())
					{
						$this->doc->appendNode("account", $_POST['account'], array("class" => "text"));
					}
					else
					{
						$error = true;
						$this->doc->appendNode("account", $_POST['account'], array("class" => "error", "error" => Lang::get("recoverpass", "notexists")));
					}

					# Miramos si la contraseña es demasiado corta
					if (strlen($_POST['passwd']) < 6)
					{
						$error = true;
						$this->doc->appendNode("passwd", $_POST['passwd'], array("class" => "error", "error" => Lang::get("recoverpass", "tooshort")));
					}
					# Miramos si coinciden las contraseñas
					else if ($_POST['passwd'] != $_POST['cpasswd'])
					{
						$error = true;
						$this->doc->appendNode("passwd", $_POST['passwd'], array("class" => "error", "error" => Lang::get("recoverpass", "notsame")));
					}
					else {
						$this->doc->appendNode("passwd", $_POST['passwd'], array("class" => "text"));
					}

					if (!$error)
					{
						# Miramos si el hash corresponde a la cuenta
						Db::query("SELECT * FROM account_changepass INNER JOIN account ON account.id_account = account_changepass.id_account WHERE hash = %s AND login = %s AND used = 0 AND account_changepass.valid = 1", array($_POST['hash'], strtolower(trim($_POST['account']))));
						if ($data = Db::resultOne())
						{
							# Cambiamos la contraseña
							Db::query("UPDATE account SET pass = %s WHERE id_account = %i", array($_POST['passwd'], $data['id_account']));

							# Marcamos como usado el codigo
							Db::query("UPDATE account_changepass SET used = 1 WHERE id = %i", array($data['id']));

							# Autenticamos al usuario y lo redirigimos al panel de control
							$_SESSION['account'] = md5($data['id_account']);
							header("Location: /" . Lang::$acronym . "/controlpanel");
							exit();
						}
						else
						{
							$error = true;
							$this->doc->appendNode("account", $_POST['account'], array("class" => "error", "error" => Lang::get("recoverpass", "codeincorrect")));
						}
					}
				}
				else
				{
					$this->doc->appendNode("account", null, array("class" => "text"));
					$this->doc->appendNode("passwd", null, array("class" => "text"));
				}

				$this->doc->appendNode("hash", $_REQUEST['hash']);
			}
		}
		else
		{
			$this->doc->appendNode("hasherror", Lang::get("recoverpass", "codenotexists"));
		}

		return $this->show();
	}

}
