<?php
/**
Language
@file config.class.php
@class Config
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

class Lang
{
	static private $lang;
	static public $acronym;
	static public $id;

	/** ************************************************************************
	* Constructor:
	***************************************************************************/
	function __construct($acronym = null)
	{
		global $LANG;

		# Init
		$this->setAcronym($acronym);
		self::$lang    = array();

		# Cargamos el fichero de idioma general
		$path        = Config::get("path", "lang");
		$fileLang    = $path . self::$acronym . ".lang.php";

		if (file_exists($fileLang)) {
			require_once($fileLang);
		}

		# Asignamos el array al atributo del objeto
		self::$lang = $LANG;
	}

	/** ************************************************************************
	* setLang:
	*   - Establece el idioma
	*   - @param fileName string (Nombre del fichero a cargar)
	***************************************************************************/
	static function setLang($fileName)
	{
		global $LANG;

		# Cargamos los ficheros del idioma
		$path        = Config::get("path", "lang");
		$fileSection = $path . "{$fileName}.lang.php";

		if (file_exists($fileSection)) {
			require_once($fileSection);
		}

		# Asignamos el array al atributo del objeto
		self::$lang = $LANG;
	}

	/** ************************************************************************
	* get:
	*   - Devuelve una variable de idioma
	*   - @param var string (Nombre del array de idioma)
	*   - @param key string (Nombre del elemento del array)
	*   - @return all
	***************************************************************************/
	static function get($var = null, $key = null)
	{
		if ($var && $key) {
			return self::$lang[$var][$key];
		}
		else if ($var) {
			return self::$lang[$var];
		}
		else {
			return self::$lang;
		}
	}

	/** ************************************************************************
	* set:
	*   - Establece una variable de idioma
	*   - @param var string (Nombre del array de idioma)
	*   - @param key string (Nombre del elemento del array)
	*   - @param value string (Valor de la variable)
	*   - @return bool
	***************************************************************************/
	static function set($var, $key, $value = null)
	{
		if (trim($var)) {
			return self::$lang[$var][$key] = $value;
		}

		return false;
	}

	/** ************************************************************************
	* setArray:
	*   - Establece un array de idioma
	*   - @param var string (Nombre del array de idioma)
	*   - @param array array assoc (Array de valores)
	*   - @return bool
	***************************************************************************/
	static function setArray($var, $array = array())
	{
		if (trim($var) && is_array($array)) {
			return self::$lang[$var] = $array;
		}

		return false;
	}

	/** ************************************************************************
	* setAcronym:
	*   - Segun la prioridad, estable el idioma del site
	*   - @param acronym string
	*   - @return bool
	***************************************************************************/
	public function setAcronym($acronym = null)
	{
		# Init
		$user = User::getCurrentUser();

		# Miramos el acronimo de la URL
		if (trim($acronym))
		{
			Db::query("SELECT * FROM language WHERE acronym = %s AND activated = 1", array(strtolower($acronym)));
			if ($data = Db::resultOne())
			{
				# Guardamos el idioma segun el usuario
				if ($user && $user->getProperty("id_lang") != $data['id_lang']) {
					Db::query("UPDATE account SET id_lang = %i WHERE id_account = %i", array($data['id_lang'], $user->getProperty("id_account")));
				}
				else if (!$user) {
					$cookie = setcookie(Config::get("cookie", "lang"), $acronym, time() + 9999999999, "/");
				}

				self::$id = $data['id_lang'];
				self::$acronym = $data['acronym'];
				return;
			}
		}

		# Miramos el idioma del usuario
		if ($user && $user->getProperty("id_lang"))
		{
			Db::query("SELECT * FROM language WHERE id_lang = %i AND activated = 1", array($user->getProperty("id_lang")));
			if ($data = Db::resultOne())
			{
				self::$id = $data['id_lang'];
				self::$acronym = $data['acronym'];
				return;
			}
		}
		else if (!$user && $_COOKIE[Config::get("cookie", "lang")])
		{
			Db::query("SELECT * FROM language WHERE acronym = %s AND activated = 1", array(strtolower($_COOKIE[Config::get("cookie", "lang")])));
			if ($data = Db::resultOne())
			{
				self::$id = $data['id_lang'];
				self::$acronym = $data['acronym'];
				return;
			}
		}

		# Miramos las preferencias del navegador
		$langs = split(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		if ($langs && is_array($langs))
		{
			foreach ($langs as $lang)
			{
				$acro = strtolower(substr($lang, 0, 2));
				Db::query("SELECT * FROM language WHERE acronym = %s AND activated = 1", array($acro));
				if ($data = Db::resultOne())
				{
					# Miramos el idioma del usuario
					if ($user) {
						Db::query("UPDATE account SET id_lang = %i WHERE id_account = %i", array($data['id_lang'], $user->getProperty("id_account")));
					}
					else
					{
						$cookie = setcookie(Config::get("cookie", "lang"), $data['acronym'], time() + 9999999999, "/");
					}

					self::$id = $data['id_lang'];
					self::$acronym = $data['acronym'];
					return;
					break;
				}
			}
		}

		# Obtenemos el idioma por defecto
		Db::query("SELECT * FROM language WHERE acronym = %s AND activated = 1", array(Config::get("site", "lang")));
		if ($data = Db::resultOne())
		{
			if ($user)
			{
				Db::query("UPDATE account SET id_lang = %i WHERE id_account = %i", array($data['id_lang'], $user->getProperty("id_account")));
			}
			else
			{
				$cookie = setcookie(Config::get("cookie", "lang"), $data['acronym'], time() + 9999999999, "/");
			}
		}

		self::$id = $data['id_lang'];
		self::$acronym = $data['acronym'];
	}

}

?>
