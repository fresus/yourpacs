<?php
/**
Section: Summary
@file summary.class.php
@class Summary
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

class Summary2 extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Obtenemos la cuenta
		$account = strtolower(trim($_GET['account']));

		# Miramos si existe la cuenta
		Db::query("SELECT * FROM account WHERE login = %s", array($account));
		if ($data = Db::resultOne())
		{
			$this->doc->appendNode("account", $account);
			Config::set("page", "title", "Yourpacs :: " . $account);
		}
		else
		{
			header("HTTP/1.0 404 Not Found");
			Die("Error 404: Not found");
			exit();
		}

		# Cambiamos la DB
		mysql_select_db($account);

		# Obtenemos los mensajes del Blog
		$items = $this->getBlog();
		$this->doc->appendNode("blog", null);
		if ($items)
		{
			foreach ($items as $item)
			{
				$this->doc->appendNode("item", $item['post_title'], array(
																	"id"   => $item['ID'],
																	"date" => date("d-m-Y H:i", strtotime($item['post_date']))
																	), "blog");
			}
		}

		# Obtenemos los enlaces
		$items = $this->getLinks();
		$this->doc->appendNode("links", null);
		if ($items)
		{
			foreach ($items as $item)
			{
				$this->doc->appendNode("item", $item['title'], array(
																	"link" => $item['enlace'],
																	"date" => date("d-m-Y H:i", strtotime($item['fecha']))
																	), "links");
			}
		}

		# Obtenemos los menajes del foro
		$items = $this->getForum();
		$this->doc->appendNode("forum", null);
		if ($items)
		{
			foreach ($items as $item)
			{
				$this->doc->appendNode("item", $item['topic_title'], array(
																	"id"   => $item['topic_id'],
																	"date" => date("d-m-Y H:i", $item['topic_time'])
																	), "forum");
			}
		}

		# Obtenemos las fotos
		$items = $this->getFotos();
		$this->doc->appendNode("fotos", null);
		if ($items)
		{
			foreach ($items as $item)
			{
				$this->doc->appendNode("item", null, array("id"     => $item['g_id'],
														   "parent" => $item['g_parentId'],
														   "date"   => date("d-m-Y H:i", $item['g_creationTimestamp'])
															), "fotos");
			}
		}

		# Obtenemos las paginas del wiki
		$items = $this->getWiki();
		$this->doc->appendNode("wiki", null);
		if ($items)
		{
			foreach ($items as $item)
			{
				$this->doc->appendNode("item", $item['page_title'], null, "wiki");
			}
		}

		mysql_select_db(Config::get("db", "dbname"));
		return $this->show();
	}

	function getBlog($limit = 10)
	{
		Db::query("SELECT ID, post_date, post_title FROM wp_posts WHERE post_status = 'publish' AND post_password = '' AND post_type = 'post' ORDER BY post_date DESC LIMIT {$limit}");
		return Db::result();
	}

	function getWiki($limit = 10)
	{
		$sql = "SELECT page_title FROM wiki_page ORDER BY page_touched DESC LIMIT {$limit}";
		Db::query($sql);
		return Db::result();
	}

	function getForum($limit = 10)
	{
		$sql = "SELECT topic_id, topic_time, topic_title
				FROM phpbb_topics
					LEFT JOIN phpbb_forums ON phpbb_forums.forum_id = phpbb_topics.forum_id
				WHERE
					auth_view = 0
				ORDER BY topic_time DESC
				LIMIT {$limit}";
		Db::query($sql);
		return Db::result();
	}

	function getLinks($limit = 10)
	{
		Db::query("SELECT title, enlace, fecha FROM sab_sabrosus WHERE (tags NOT LIKE '%:sab:privado%') ORDER BY fecha DESC LIMIT {$limit}");
		return Db::result();
	}

	function getFotos($limit = 6)
	{
		$sql = "SELECT g2_Entity.g_id, g_creationTimestamp, g_parentId
				FROM g2_Entity
					LEFT JOIN g2_ChildEntity ON g2_ChildEntity.g_id = g2_Entity.g_id
					LEFT JOIN g2_DerivativeImage ON g2_DerivativeImage.g_id = g2_Entity.g_id
				WHERE
					g_serialNumber = 2 AND
					g_isLinkable = 0 AND
					g_onLoadHandlers IS NULL AND
					g_width <= 150 AND
					g_parentId NOT IN(SELECT g_id FROM g2_Entity WHERE g_isLinkable = 1 AND g_onLoadHandlers IS NOT NULL)
				ORDER BY g_creationTimestamp DESC
				LIMIT {$limit}
				";
		Db::query($sql);
		return Db::result();
	}
}
