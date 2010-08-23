<?php
/**
Debug
@file debug.class.php
@class Debug
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

class Debug
{
	static $content;
	static $timer;

	/** ************************************************************************
	* Constructor:
	***************************************************************************/
	function __construct()
	{
		# Init
		self::$content = array();
		self::$timer   = 0;
	}

	/** ************************************************************************
	* set:
	*   - Asigna un elemento a la pila del debug
	*   - @param elem array | object | string
	*   - @param title title
	*   - @return bool
	***************************************************************************/
	static function set($elem, $title = "Debug")
	{
		# Init
		self::$content[] = array("title" => $title,
								 "value" => $elem);
		return true;
	}

	/** ************************************************************************
	* code:
	*   - Vacia la pila, muestra el contenido del debug y detiene la ejecucion
	*   - @param elem array | object | string
	*   - @param title title
	*   - @return bool
	***************************************************************************/
	static function code($elem, $title = "Debug")
	{
		# Init
		self::$content = array();
		self::$content[] = array("title" => $title,
								 "value" => $elem);

		echo self::getHtml();
		exit();
	}

	/** ************************************************************************
	* getHTML:
	*   - Devuelve el HTML del debug
	*   - @return string HTML
	***************************************************************************/
	static function getHTML()
	{
		if (self::$content[0])
		{
			# Init
			$doc = new BuildXML("debug");

			# Añadimos path de JAVASCRIPT
			$doc->appendNode("js", "/" . Config::get("path", "js"), array("version" => Config::get("site", "versionjs")), "path");

			# Añadimos los nodos de debug
			foreach (self::$content as $element)
			{
				if     (is_object($element['value'])) $value = print_r($element['value'], true);
				elseif (is_array($element['value']))  $value = print_r($element['value'], true);
				else $value = print_r(htmlentities($element['value']), true);

				$doc->arrayToNodes(array(array(
										tag   => "item",
										value => $value,
										atr   => array(title => $element['title'])
										)), "debug");
			}

			# Juntamos el XSL con el XML
			$transform = new BuildHTML("debug", $doc->getDocument());

			return utf8_encode($transform->getHtml());
		}

		return false;
	}

	static function timerStart()
	{
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		self::$timer = $mtime;
	}

	static function timerEnd($title = "Timer")
	{
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];

		self::set($mtime - self::$timer, $title);

		return ("{$title}: " . ($mtime - self::$timer));
	}

}

?>