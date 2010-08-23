<?php
/**
Section: Home
@file home.php
@class Home
@version 1.0
@date 3 de marzo del 2007
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

class Home extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		Config::set("page", "title", Lang::get("home", "pagetitle"));

	#	# Obtiene mensajes aleatorios
	#	Db::query("SELECT * FROM lastposts_blog ORDER BY RAND() LIMIT 98");
	#	while ($data = Db::resultOne())
	#	{
	#		$title = (strlen($data['title']) > 70) ? substr($data['title'], 0, 69) . "..." : $data['title'];
	#		$this->doc->appendNode("item", str_replace("\"", "", utf8_encode(html_entity_decode($title))), array("url" => $data['link'],
	#															"login" => $data['login'],
	#															"date" => date("d-m-Y H:i", $data['date']))
	#															, "lastpostsblog");
	#	}

	#	# Obtiene mensajes de los blogs "no oficiales"
	#	Db::query("SELECT * FROM lastposts_blog WHERE login = 'fernandoalonso' ORDER BY RAND() LIMIT 1");
	#	$data = Db::resultOne();
	#	$this->doc->appendNode("item", str_replace("\"", "", utf8_encode(html_entity_decode($data['title']))), array("url" => $data['link'], "login" => $data['login'], "date" => date("d-m-Y H:i", $data['date'])), "lastpostsblog");
	#	Db::query("SELECT * FROM lastposts_blog WHERE login = 'playboy' ORDER BY RAND() LIMIT 1");
    #    $data = Db::resultOne();
    #    $this->doc->appendNode("item", str_replace("\"", "", utf8_encode(html_entity_decode($data['title']))), array("url" => $data['link'], "login" => $data['login'], "date" => date("d-m-Y H:i", $data['date'])), "lastpostsblog");
    #    Db::query("SELECT * FROM lastposts_blog WHERE login = 'tutorial' ORDER BY RAND() LIMIT 1");
    #    $data = Db::resultOne();
    #    $this->doc->appendNode("item", str_replace("\"", "", utf8_encode(html_entity_decode($data['title']))), array("url" => $data['link'], "login" => $data['login'], "date" => date("d-m-Y H:i", $data['date'])), "lastpostsblog");


	#	# Obtiene usuarios aleatorios
	#	Db::query("SELECT * FROM account ORDER BY date DESC LIMIT 9");
	#	while ($data = Db::resultOne())
	#	{
	#		$this->doc->appendNode("item", $data['login'], null, "randomusers");
	#	}

		return $this->show();
	}
}
