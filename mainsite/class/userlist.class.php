<?php
/**
Section: Userlist
@file userlist.php
@class Userlist
@version 1.0
@date 4 de abril del 2007
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

class Userlist extends Section
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
		$categorys = array();

		Config::set("page", "title", Lang::get("userlist", "pagetitle"));

		# Recorremos las tematicas
		Db::query("SELECT * FROM thematic_lang WHERE id_lang = %i ORDER BY id_thematic = 4 DESC, name ASC", array(Lang::$id));
		$total = Db::num();
		$mod   = ceil($total / 4);
		while ($data = Db::resultOne())
		{
			if (++$num % $mod == 0) { $newcol = 1; } else { $newcol = 0; }
			$categorys[$data['id_thematic']] = $this->doc->appendNode("item", null, array("id" => $data['id_thematic'], "name" => $data['name'], "num" => $newcol), "thematic");
		}

		# Creamos el array de cuentas por categorias que tienen posts en el blog
		$sql = "SELECT lastposts_blog.login, thematic.id_thematic
				FROM lastposts_blog
					LEFT JOIN account ON account.id_account = lastposts_blog.id_account
					LEFT JOIN thematic ON thematic.id_thematic = account.id_thematic
				GROUP BY lastposts_blog.id_account
				HAVING thematic.id_thematic IS NOT NULL
				ORDER BY lastposts_blog.login ASC";

		Db::query($sql);
		while ($data = Db::resultOne()) {
			$this->doc->appendNode("useritem", $data['login'], null, $categorys[$data['id_thematic']]);
		}

		return $this->show();
	}

}