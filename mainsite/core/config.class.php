<?php
/**
Config
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

class Config
{
	static private $config;

	/** ************************************************************************
	* Constructor:
	*   - @param config array (Array de configuracion)
	***************************************************************************/
	function __construct($config)
	{
		self::$config = $config;

		# Vaciamos el array de configuracion
		global $CONFIG;
		unset($CONFIG);
	}

	/** ************************************************************************
	* get:
	*   - Devuelve una variable de configuracion
	*   - @param var string (Nombre del array de configuracion)
	*   - @param key string (Nombre del elemento del array)
	*   - @return all
	***************************************************************************/
	static function get($var = null, $key = null)
	{
		if ($var && $key) {
			return self::$config[$var][$key];
		}
		else if ($var) {
			return self::$config[$var];
		}
		else {
			return self::$config;
		}
	}

	/** ************************************************************************
	* set:
	*   - Establece una variable de configuracion
	*   - @param var string (Nombre del array de configuracion)
	*   - @param key string (Nombre del elemento del array)
	*   - @param value string (Valor de la variable)
	*   - @return bool
	***************************************************************************/
	static function set($var, $key, $value = null)
	{
		if (trim($var)) {
			return self::$config[$var][$key] = $value;
		}

		return false;
	}

	/** ************************************************************************
	* setArray:
	*   - Establece un array de configuracion
	*   - @param var string (Nombre del array de configuracion)
	*   - @param array array assoc (Array de valores)
	*   - @return bool
	***************************************************************************/
	static function setArray($var, $array = array())
	{
		if (trim($var) && is_array($array)) {
			return self::$config[$var] = $array;
		}

		return false;
	}

}

?>