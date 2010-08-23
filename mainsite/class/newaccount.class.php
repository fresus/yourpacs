<?php
/**
Section: New Account
@file newaccount.class.php
@class Newaccount
@version 1.0
@date 7 de marzo del 2007
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

class Newaccount extends Section
{
	/** ************************************************************************
	* Constructor
	*    - @param section string (Nombre de la seccion)
	***************************************************************************/
	function __construct($section = null)
	{
		parent::__construct($section);

		if (User::getCurrentUser()) {
			header("Location: /" . Lang::$acronym . "/controlpanel");
			exit();
		}
	}

	/** ************************************************************************
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - @return DOM object
	***************************************************************************/
	public function perform()
	{
		# Init
		Config::set("page", "title", Lang::get("newaccount", "pagetitle"));

		# Creamos el array de Javascript con el idioma de los errores
		# para pasarselo a la funcion de validacion
		foreach (Lang::get("newaccount", "error") as $error) {
			$errors .= "'" . $error . "',";
		}
		$errors = substr($errors, 0, strlen($errors) - 1);
		$errors = "Array($errors)";
		$this->doc->appendNode("texterror", $errors);

		# Añadimos los nodos de las categorias
		#$sql = "SELECT *
		#		FROM category
		#			LEFT JOIN category_lang ON category_lang.id_category = category.id_category
		#		WHERE id_lang = %i
		#		ORDER BY 'order' ASC";
		#Db::query($sql, array(Lang::$id));
		#foreach (Db::result() as $data)
		#{
		#	# Creamos el nodo de la categoria
		#	$node  = $this->doc->appendNode("item", null, array("name" => $data['name'], "id" => $data['id_category']), "category");
		#	$node2 = $this->doc->appendNode("thematic", null, null, $node);

		#	# Obtenemos las tematicas
		#	$sql = "SELECT *
		#			FROM thematic
		#				LEFT JOIN thematic_lang ON thematic_lang.id_thematic = thematic.id_thematic
		#			WHERE
		#				id_lang = %i AND
		#				id_category = %i
		#			ORDER BY name ASC";
		#	Db::query($sql, array(Lang::$id, $data['id_category']));
		#	foreach (Db::result() as $data2) {
		#		$this->doc->appendNode("item", $data2['name'], array("id" => $data2['id_thematic']), $node2);
		#	}
		#}

		return $this->show();
	}
}
