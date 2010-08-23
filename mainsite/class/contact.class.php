<?php
/**
Section: Contact
@file contact.php
@class Contact
@version 1.0
@date 23 de marzo del 2007
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

class Contact extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		$user = User::getCurrentUser();
        Config::set("page", "title", Lang::get("home", "pagetitle"));

		if ($_POST['text'])
		{
			if (!$user)
			{
				if (!ereg("[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9\.\-_]*\.[a-zA-Z]{2,4}", $_POST['email'])) {
					$this->doc->appendNode("email", $_POST['email'], array("error" => Lang::get("contact", "error1"), "class" => "error"));
					$this->doc->appendNode("success", 0);
					$error = true;
				}
			}

			if (strlen(trim($_POST['text'])) < 50) {
				$this->doc->appendNode("text", $_POST['text'], array("error" => Lang::get("contact", "error2"), "class" => "error"));
				$this->doc->appendNode("success", 0);
			}
			else if (!$error)
			{
				# Insertamos el mensaje de contacto y mostramos el mensje de succes
				$this->addContact(trim($_POST['email']), trim($_POST['text']));
				$this->doc->appendNode("success", 1);
			}
			else {
				$this->doc->appendNode("text", $_POST['text'], array("class" => "textarea"));
			}
		}
		else
		{
			$this->doc->appendNode("email", null, array("class" => "text"));
			$this->doc->appendNode("text", null, array("class" => "textarea"));
			$this->doc->appendNode("success", 0);
		}

		return $this->show();
	}

	public function addContact($email, $text)
	{
		$user   = User::getCurrentUser();
		$iduser = $user ? $user->getProperty("id_account") : 0;
		$email  = $user ? $user->getProperty("email") : $email;

		Db::query("INSERT INTO contact (id_user, email, date, text) VALUES (%i, %s, NOW(), %s)", array($iduser, $email, $text));
	}

}
