<?php
/**
Section: Verify Account
@file verifyaccount.class.php
@class Verifyaccount
@version 1.0
@date 16 de marzo del 2007
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

class Verifyaccount extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		$name = trim($_POST['account']);

		# Eliminamos los acentos y dieresis en los nombres
		$name = strtr($name, "àèìòùáéíóúäëïüöâêîôûçñ", "aeiouaeiouaeiouaeioucn");

		# Eliminamos los acentos y dieresis en los nombres
		$name = strtr($name, "ÀÈÌÒÙÁÉÍÓÚÄËÏÖÜÂÊÎÔÛÇÑ", "AEIOUAEIOUAEIOUAEIOUCN");

		$name    = strtolower($name);
		$email   = strtolower(trim($_POST['email']));
		$captcha = $_POST['captcha'];

		# Miramos si el nombre es correcto
		if (strlen($name) < 4)
		{
			$nameValid = "1|" . utf8_encode(Lang::get("verifyaccount", "error1"));
		}
		else if (ereg("^[a-z]{1}[a-z0-9\-_]{2,14}[a-z0-9]{1}$", $name))
		{
			Db::query("SELECT * FROM account WHERE login = %s", array($name));
			$data1 = Db::result();

			Db::query("SELECT * FROM blacklist WHERE login = %s", array($name));
			$data2 = Db::result();

			if ($data1) {
				$nameValid = "3|" . utf8_encode(Lang::get("verifyaccount", "error3"));
			}
			else if ($data2) {
				$nameValid = "3|" . utf8_encode(Lang::get("verifyaccount", "error3"));
			}
			else {
				$nameValid = "0|ok";
			}
		}
		else
		{
			$nameValid = "2|" . utf8_encode(Lang::get("verifyaccount", "error2"));
		}


		# Miramos el email es correcto
		if (!ereg("[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9\.\-_]*\.[a-zA-Z]{2,4}", $email))
		{
			$nameValid .= "|1|" . utf8_encode(Lang::get("verifyaccount", "error4"));
		}
		else
		{
			Db::query("SELECT * FROM account WHERE lower(email) = lower(%s)", array($email));
			if (Db::result()) {
				$nameValid .= "|2|" . utf8_encode(Lang::get("verifyaccount", "error3"));
			}
			else {
				$nameValid .= "|0|ok";
			}
		}


		# Miramos el codigo de captcha
		if ($_SESSION['captcha'] != $captcha) {
			$nameValid .= "|1|" . utf8_encode(Lang::get("verifyaccount", "error5"));
		}
		else {
			$nameValid .= "|0|ok";
		}

		$this->doc->appendNode("valid", $nameValid);

		return $this->show();
	}
}
