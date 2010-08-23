<?php
/**
User
@file user.class.php
@class User
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

class User
{
	static private $currentUser;

	private $id_account;
	private $id_lang;
	private $login;
	private $email;
	private $date;
	private $newsmail;
    private $type;

	/** ************************************************************************
	* Constructor:
	***************************************************************************/
	function __construct() {}

	/** ************************************************************************
	* clear:
	*   - Vacia el objeto
	*   - @param currentUser bool (Elimina tambien el usuario actual)
	*   - @return bool
	***************************************************************************/
	public function clear($currentUser = false)
	{
		$this->__construct();

		if ($currentUser)
		{
			self::$currentUser = null;
		}

		return true;
	}

	/** ************************************************************************
	* setUser:
	*   - Asigna valores a los atributos
	*   - @param primary array assoc (Datos primarios del usuario)
	***************************************************************************/
	private function setUser($primary)
	{
		if (is_array($primary))
		{
			foreach ($primary as $key => $value)
			{
				$this->$key = $value;
			}
		}
	}

	/** ************************************************************************
	* setCurrentUserBySession:
	*   - Establece el usuario autenticado mediante el uso de una session
	***************************************************************************/
	public function setCurrentUserBySession()
	{
		if (trim($_SESSION['account']))
		{
			self::$currentUser = $this->getUserById($_SESSION['account'], $md5 = true);
		}
	}

	/** ************************************************************************
	* getUserById
	*   - Obtiene un usuario segun su ID
	*   - @param id integer | md5 (segun si @param md5 esta en true)
	*   - @param md5 bool (calcula un md5 del identificador)
	*   - @return User Object
	***************************************************************************/
	public function getUserById($id, $md5 = false)
	{
		if ($md5) {
			$sql = "SELECT * FROM account WHERE md5(id_account) = %s";
		}
		else {
			$sql = "SELECT * FROM account WHERE id_account = %i";
		}

		Db::query($sql, array($id));
		if ($data = Db::resultOne())
		{
			$this->setUser($data);
			return $this;
		}

		return false;
	}

	/** ************************************************************************
	* getCurrentUser:
	*   - Obtiene el usuario autenticado
	*   - @return User Object
	***************************************************************************/
	static function getCurrentUser()
	{
		# Init
		$user = self::$currentUser;

		if ($user && $user->id >= 0) {
			return $user;
		}

		return false;
	}

	/** ************************************************************************
	* setProperty:
	*   - Metodo que asigna valores a las propiedades
	*   - @param property: string (nombre de la propiedad)
	*   - @param value: all type (valor para la propiedad)
	***************************************************************************/
	public function setProperty($property, $value = null) {
		$this->$property = $value;
	}


	/** ************************************************************************
	* getProperty:
	*   - Metodo que devuelve una propiedad.
	*   - @param property: string (nombre de la propiedad)
	*   - @return property
	***************************************************************************/
	public function getProperty($property) {
		return $this->$property;
	}

}
