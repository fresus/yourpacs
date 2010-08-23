<?php
/**
Section: Webservice
@file webservice.class.php
@class Webservice
@version 1.0
@date 14 de abril del 2007
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

class Webservice extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		$account = strtolower(trim($_REQUEST['account']));

		# Factoria
		switch (strtolower(trim($_REQUEST['cmd'])))
		{
			case "headservices":
				$this->headservices($account);
				break;
			case "listusers":
				$this->listusers($_REQUEST['passwd']);
				break;
		}

		exit();
		return $this->show();
	}

	function headservices($account = null)
	{
		# Si hay account lo cogemos y si no pues miramos el referer
		if (trim($account))
		{
			Db::query("SELECT id_account, login, domain FROM account WHERE login = %s", array(strtolower(trim($account))));
			$data   = Db::resultOne();
			$domain = $data['domain'] ? $data['domain'] : $data['login'] . ".lynksee.com";
		}
		else {
			# Obtenemos el referer
			$referer = strtolower($_SERVER['HTTP_REFERER']);

			# Limpiamos el referer y obtenemos el subdominio
			$referer = str_replace("ftp://", "", $referer);
			$referer = str_replace("http://", "", $referer);
			$referer = str_replace("https://", "", $referer);

			# Obtenemos el subdominio
			$subdomain = explode("/", $referer);
			$partes = explode(".", $subdomain[0]);

			if ("{$partes[1]}.{$partes[2]}" == "lynksee.com")
			{
				Db::query("SELECT id_account, login, domain FROM account WHERE login = %s", array($partes[0]));
				$data   = Db::resultOne();
				$domain = $data['domain'] ? $data['domain'] : $data['login'] . ".lynksee.com";
			}
			else
			{
				Db::query("SELECT id_account, login, domain FROM account WHERE domain = %s", array($subdomain[0]));
				$data   = Db::resultOne();
				$domain = $data['domain'];
			}
		}

		if ($data['id_account'])
		{
			header("Content-Type: text/plain");

			# Precarga de imagenes
			echo "var pic1 = new Image(24, 24); pic1.src = \"http://www.lynksee.com/img/minilogos/lynksee_s.png\";\n";
			echo "var pic2 = new Image(24, 24); pic2.src = \"http://www.lynksee.com/img/minilogos/wordpress.png\";\n";
			echo "var pic3 = new Image(24, 24); pic3.src = \"http://www.lynksee.com/img/minilogos/gallery2.png\";\n";
			echo "var pic4 = new Image(24, 24); pic4.src = \"http://www.lynksee.com/img/minilogos/mediawiki.png\";\n";
			echo "var pic5 = new Image(24, 24); pic5.src = \"http://www.lynksee.com/img/minilogos/sabrosus.png\";\n";
			echo "var pic6 = new Image(24, 24); pic6.src = \"http://www.lynksee.com/img/minilogos/phpbb.png\";\n";
			echo "var pic7 = new Image(24, 24); pic7.src = \"http://www.lynksee.com/img/minilogos/joomla.png\";\n";

			# Obtenemos el software instalado del usuario
			$sql = "SELECT *
					FROM account_software
						LEFT JOIN software ON software.id = account_software.id_software
					WHERE id_account = %i
					ORDER BY software.order ASC";
			Db::query($sql, array($data['id_account']));
			while ($soft = Db::resultOne())
			{
				echo "document.write('<a href=\"http://{$domain}/{$soft['alias']}/\" title=\"{$soft['name']}\" style=\"text-decoration: none;\"><img src=\"http://www.lynksee.com/img/minilogos/{$soft['icon_shadow']}\" alt=\"{$soft['name']}\" onMouseOver=\"this.src=\'http://www.lynksee.com/img/minilogos/{$soft['icon']}\';\" onMouseOut=\"this.src=\'http://www.lynksee.com/img/minilogos/{$soft['icon_shadow']}\';\" style=\"border: 0px; margin: 0px 3px 0px 0px; padding: 0px;\" border=\"0\"/></a>');\n";
			}
		}
	}

	function listusers($passwd)
	{
		echo "Acceso denegado";
		exit();

		if ($passwd == "manoloeldelbombo")
		{
			header("Content-Type: text/plain");

			Db::query("SELECT * FROM account ORDER BY login ASC");
			while ($data = Db::resultOne())
			{
				echo "{$data['login']}.lynksee.com /var/www/lynksee.com/{$data['login']}/{$data['dir1']}/{$data['dir2']}\n";
			}
		}
	}

}
