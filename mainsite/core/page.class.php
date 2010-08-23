<?php
/**
Page Controler
@file page.class.php
@class Page
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

class Page
{
	private $section;
	private $sectionString;
	private $sectionsRequired;
	private $documents;

	private $ajax;

	/** ************************************************************************
	* Constructor:
	*   - Requiere una seccion
	*   - @param sectionString string (Seccion a instanciar)
	*   - @param ajax bool (si la peticion es del tipo ajax)
	***************************************************************************/
	function __construct($sectionString, $ajax = false)
	{
		# Init
		$this->documents        = array();
		$this->sectionString    = trim(strtolower($sectionString));
		$this->ajax             = $ajax;

		# Miramos si tenemos subdominio
		$host = strtolower($_SERVER['HTTP_HOST']);
		$host = str_replace("http://", "", $host);
		$host = explode(".", $host);
/*		if ($host[0] != "www" && $host[0] != "lynksee")
		{
			# Miramos si es una cuenta valida
			Db::query("SELECT * FROM account WHERE login = %s", array(strtolower(trim($host[0]))));
			if ($data = Db::resultOne()) {
				$this->sectionString = "summary";
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die("Error 404: Not found");
				exit();
			}
		}
*/
		# Establece la seccion a mostrar
		$this->section = $this->searchClass();
	}

	/** ************************************************************************
	* show:
	*   - Muestra la pagina
	*   - @return string
	***************************************************************************/
	function show()
	{
		# Comprobamos que exista la clase
		if (is_object($this->section))
		{
			$xml = $this->section->perform();
		}
		else
		{
			header("HTTP/1.0 404 Not Found");
			die("Error 404: Not found");
			exit();
		}

		# Asignamos el titulo de la páina y la seccion actual
		$xml->appendNode("title", Config::get("page", "title"), null, "page");
		$xml->appendNode("section", $this->sectionString, null, "page");
		$xml->appendNode("acronym", Lang::$acronym, null, "page");

		# Comprobamos si existen las hojas de estilo para este site
		$cssPathSite = Config::get("path", "web") . Config::get("path", "css");

		# Asignamos los estilos a la pagina
		$xml->appendNode("css", "/" . Config::get("path", "css"), null, "path");
		$xml->appendNode("item", "styles.css", array("version" => Config::get("site", "versioncss")), "styles");
		if (file_exists($cssPathSite . $this->sectionString . ".css")) {
			$xml->appendNode("item", $this->sectionString . ".css", array("version" => Config::get("site", "versioncss")), "styles");
		}

		# Asignamos los path necesarios
		$xml->appendNode("img", "/" . Config::get("path", "images"), null, "path");
		$xml->appendNode("js",  "/" . Config::get("path", "js"), array("version" => Config::get("site", "versionjs")), "path");

		# Asignamos el Javascript de la seccion
		$jsPathSite = Config::get("path", "web") . Config::get("path", "js");
		if (file_exists($jsPathSite . $this->sectionString . ".js")) {
			$xml->appendNode("item", $this->sectionString . ".js", array("version" => Config::get("site", "versionjs")), "javascript");
		}

		# Obtenemos los datos del usuario
		if ($user = User::getCurrentUser())
		{
			$domain = $user->getProperty("domain") ? $user->getProperty("domain") : $user->getProperty("login") . ".lynksee.com";
			$xml->appendNode("user", null);
			$xml->appendNode("id", $user->getProperty("id_account"), null, "user");
			$xml->appendNode("login", trim($user->getProperty("login")), array("url" => urlencode(trim($user->getProperty("login")))), "user");
			$xml->appendNode("domain" , $domain, null, "user");
		}
		else
		{
			$xml->appendNode("user", null);
			$xml->appendNode("id", "0", null, "user");
		}

		# Insertamos la rama del idioma
		$langNode = $xml->appendNode("language", null);
	 	foreach (Lang::get() as $key => $arrayKey)
	 	{
	 	 	$node = $xml->appendNode($key, null, null, $langNode);
			foreach ($arrayKey as $key => $value)
			{
				if (!is_array($value)) {
					$xml->appendNode($key, $value, null, $node);
				}
			}
		}

		# Insertamos los idiomas disponibles
		foreach ($this->getLanguages() as $lang)
		{
		 	$xml->appendNode("item", trim($lang['name']), array(
			 						  					   "acronym" => trim($lang['acronym']),
			 						  					   "locale"  => trim($lang['locale'])), "languages");
		}

		# Creamos y transformamos el documento final
		$finalDoc = new BuildHTML($this->sectionString, $xml->getDocument());

		return $finalDoc->getHTML();
	}

	/** ************************************************************************
	* searchClass
	*   - Busca la clase de la seccion y la instancia si la encuentra
	*   - @param section string (Section a buscar)
	*   - @return bool
	***************************************************************************/
	function searchClass($section = null)
	{
		# Init
		$section = strtolower(trim($section)) ? strtolower(trim($section)) : strtolower(trim($this->sectionString));

		# Miramos si la clase que queremos instanciar esta prohibida
		foreach (Config::get("system", "forbiddenclass") as $item)
		{
			if (strtolower(trim($item)) == $section) return false;
		}

		# Miramos si existe la seccion solicitada
		if (file_exists(Config::get("path", "sections") . "{$section}.class.php"))
		{
			# Formateamos el nombre de la clase
			$class = ucfirst($section);

			# Instanciamos la clase
			include_once(Config::get("path", "sections") . "{$section}.class.php");
			return new $class($section);
		}

		return false;
	}

	/** ************************************************************************
	* getLanguages:
	*   - Obtiene los idiomas activados de la pagina
	*   - @return array | false
	***************************************************************************/
	function getLanguages()
	{
	 	Db::query("SELECT * FROM language WHERE activated = 1 ORDER by \"order\" ASC");
	 	return Db::result();
	}

	/** ************************************************************************
	* setAttribute:
	*   - Asigna un valor a un atributo del objecto.
	*   - @param attribute string (Nombre del atributo)
	*   - @param value all (Valor para el atributo)
	***************************************************************************/
	function setAttribute($attribute, $value) {
		$this->$attribute = $value;
	}

	/** ************************************************************************
	* getAttribute:
	*   - Obtiene un atributo del objecto.
	*   - @param attribute string (Nombre del atributo)
	*   - @return attribute
	***************************************************************************/
	function getAttribute($attribute) {
		return $this->$attribute;
	}

}
