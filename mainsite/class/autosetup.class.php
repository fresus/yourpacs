<?php
/**
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

class Autosetup extends Section
{
	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
        $user = addslashes($_POST['user']);
        $pass = addslashes($_POST['pass']);
        
		Db::query("SELECT * FROM account WHERE login = %s AND pass = %s", 
            array(strtolower(trim($user)), trim($pass)));

        if ($data = Db::resultOne()) {
            $this->doc->appendNode("msg", "OK");
        } else {
            $this->doc->appendNode("msg", "KO");
        }
        
		return $this->show();
	}
}
