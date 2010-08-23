<?php
/**
Section: Help
@file help.php
@class Help
@version 1.0
@date 14 de marzo del 2007
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

class Help extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		$key = trim($_GET['key']);

		if ($key)
		{
			$help = $this->getHelp($key);

			Config::set("page", "title", Lang::get("help", "pagetitle") . $help['title']);

			# Añadimos los datos
			$this->doc->appendNode("title", $help['title']);
			$this->doc->appendNode("value", $help['value']);
		}
		else
		{
			if ($help = $this->getAllHelp())
			{
				Config::set("page", "title", Lang::get("help", "alltitle"));

				foreach ($help as $item) {
					$this->doc->appendNode("item", $item['value'], array("title" => $item['title']), "listhelp");
				}
			}
		}

		return $this->show();
	}

	function getHelp($key)
	{
		Db::query("SELECT * FROM help WHERE id_lang = %i AND `key` = %s", array(Lang::$id, $key));
		return Db::resultOne();
	}

	function getAllHelp()
	{
		Db::query("SELECT * FROM help WHERE id_lang = %i ORDER BY help.order ASC", array(Lang::$id));
		return Db::result();
	}
}