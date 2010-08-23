<?php
/**
DataBase
@file db.class.php
@class Db
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

class Db
{
	static private $descriptor;
	static private $debug;
	static public $cursor;
	static public $query;

	static public $error;

	/** ************************************************************************
	* Constructor:
	***************************************************************************/
	function __construct($host, $login, $pass, $dbname)
	{
		self::$descriptor = mysql_pconnect(trim($host), trim($login), trim($pass));
		self::$cursor = null;
		self::$query  = null;
		self::$error  = array();

		self::$debug  = Config::get("debug", "db");

		mysql_select_db($dbname);
		mysql_query("SET NAMES `utf8`");
	}

	/** ************************************************************************
	* query:
	*   - Ejecuta la query, guarda el cursor como ultimo y lo retorna
	*   - @param query string (SQL query)
	*   - @param params array (array de parametros)
	*   - @return cursor | false
	***************************************************************************/
	static function query($query, $params = array())
	{
		# Init
		$patterns = array("%i", "%s", "%b", "%f", "%d", "%l");
		$boolOK   = array(1, "1", "t", "true", "ok", "yes", "y");
		$boolKO   = array(0, "0", "f", "false", "ko", "no", "n");
		$last     = 0;
		$poss     = array();
		$query    = trim($query);
		$query2   = trim($query);

		# Obtenemos todas la posiciones de los parametros
		while (strpos($query2, "%") !== false)
		{
			$pos = strpos($query2, "%");

			$type = substr($query2, $pos, 2);
			if (in_array($type, $patterns)) {
				$poss[] = array("pos"  => $last + $pos,
								"type" => $type);
			}

			$query2 = substr($query2, $pos + 1);
			$last += $pos + 1;
		}

		# Contamos las posiciones a remplazar y el numero de parametros
		if (count($poss) != count($params)) {
			self::$error[] = "El nmero de parametros no se corresponde con los requeridos por la consulta.";
		}

		if (count($poss))
		{
			# Recorremos las posiciones y vamos remplazando los parametros
			$last = 0;
			$i    = 0;
			foreach ($poss as $pos)
			{
				if (!$finalquery) {
					$finalquery = substr($query, 0, $pos['pos']);
				}
				else {
					$numchars    = $pos['pos'] - $last;
					$finalquery .= substr($query, $last + 2, $numchars - 2);
				}

				# Formateamos los valores para evitar SQL injections
				switch ($pos['type'])
				{
					case "%i":
						if (!is_numeric($params[$i])) {
							self::$error[] = "El par�etro {$params[$i]}({$pos['type']} - [{$params[$i]}]) no es integer.";
						}
						else {
							$finalquery .= (int)$params[$i];
						}
						break;

					case "%b":
						if ((in_array($params[$i], $boolOK) || $params[$i] === true) && $params[$i] !== 0) {
							$finalquery .= "1";
						}
						else if (in_array($params[$i], $boolKO) || $params[$i] === false) {
							$finalquery .= "0";
						}
						else {
							self::$error[] = "El par�etro {$params[$i]} no es bool.";
						}
						break;

					case "%f":
						if (!ereg("[0-9\-\.\+]*", $params[$i])) {
							self::$error[] = "El par�etro {$params[$i]} no es float.";
						}
						else {
							$finalquery .= $params[$i];
						}
						break;

					case "%l":
						$finalquery .= addslashes($params[$i]);
						break;

					default:
						$finalquery .= "'" . addslashes($params[$i]) . "'";
				}

				$last = $pos['pos'];
				$i++;
			}
			$finalquery .= substr($query, $last + 2);
		}
		else {
			$finalquery = $query;
		}

		# Comprobamos si hay algun error
		if (count(self::$error))
		{
			if (self::$debug)
			{
				array_unshift(self::$error, $finalquery);
				Debug::set(self::$error, "Error en par�etros de QUERY");
				self::$error = array();
			}
			return false;
		}

		# Guardamos la query final y hacemos el retorno
		self::$query  = $finalquery;
		self::$cursor = mysql_query($finalquery, self::$descriptor);

		if (self::$cursor) {
			self::debug(false, self::$cursor);
			return self::$cursor;
		}
		else {
			self::debug(false, self::$cursor);
			return false;
		}
	}

	/** ************************************************************************
	* result:
	*   - Devuelve un array con los registros de la ultima query
	*   - @param type string (assoc|num)
	*   - @param cursor cursor DB
	*   - @return array
	***************************************************************************/
	static function result($type = "assoc", $cursor = null)
	{
		# Init
		$result = array();
		$cursor = $cursor ? $cursor : self::$cursor;

		switch (trim($type))
		{
			case "num":
				while ($data = mysql_fetch_array($cursor)) {
					$result[] = $data;
				}
				break;

			case "object":
				while ($data = mysql_fetch_object($cursor)) {
					$result[] = $data;
				}
				break;

			default:
				while ($data = mysql_fetch_assoc($cursor)) {
					$result[] = $data;
				}
		}

		if (count($result)) {
			return $result;
		}

		return false;
	}

	/** ************************************************************************
	* resultOne:
	*   - Devuelve un array con la primera fila encontrada
	*   - @param type string (assoc|num|object)
	*   - @param cursor cursor DB
	*   - @return array
	***************************************************************************/
	static function resultOne($type = "assoc", $cursor = null)
	{
		# Init
		$cursor = $cursor ? $cursor : self::$cursor;

		switch (trim($type))
		{
			case "num":
				$data = mysql_fetch_array($cursor);
				break;

			case "object":
				$data = mysql_fetch_object($cursor);
				break;

			default:
				$data = mysql_fetch_assoc($cursor);
		}

		if (is_object($data) || is_array($data)) {
			return $data;
		}

		return false;
	}

	/** ************************************************************************
	* value:
	*   - Devuelve un valor especifico de una fila
	*   - @param field string (Nombre del campo)
	*   - @param row integer (Numero de la fila)
	*   - @param cursor cursor DB
	*   - @return all
	***************************************************************************/
	static function value($field, $row = 0, $cursor = null)
	{
		# Init
		$field  = trim($field);
		$row    = (int)$row;
		$cursor = $cursor ? $cursor : self::$cursor;

		if (!mysql_num_rows($cursor)) {
			return false;
		}

		return mysql_result($cursor, $row, $field);
	}

	/** ************************************************************************
	* num:
	*   - Devuelve el numero de registros de la ultima query
	*   - @param cursor cursor DB
	*   - @return integer
	***************************************************************************/
	static function num($cursor = null)
	{
		# Init
		$cursor = $cursor ? $cursor : self::$cursor;

		return mysql_num_rows($cursor);
	}

	/** ************************************************************************
	* id:
	*   - Devuelve el ultimo identificador generado
	*   - @param cursor cursor DB
	*   - @return integer
	***************************************************************************/
	static function id()
	{
		return mysql_insert_id();
	}

	static function free($cursor = null)
	{
		# Init
		$cursor = $cursor ? $cursor : self::$cursor;

		return mysql_free_result($cursor);
	}

	/** ************************************************************************
	* debug:
	*   - Mira si esta el Debug activado y a�de la query.
	*   - @param cursor cursor DB
	*   - @param show bool
	***************************************************************************/
	static function debug($show = false, $cursor = null)
	{
		# Init
		$cursor = $cursor ? $cursor : self::$cursor;
		$error  = mysql_error();

		if ((self::$debug && $error) || (self::$debug && $show))
		{
			$error = $error ? "\n\n" . $error : null;
			Debug::set(self::$query . $error, "Error en QUERY");
		}
	}

	/** ************************************************************************
	* getDescriptor:
	*   - Devuelve la conexion a la DB
	*   - @return descriptor DB
	***************************************************************************/
	static public function getDescriptor()
	{
		return self::$descriptor;
	}
}