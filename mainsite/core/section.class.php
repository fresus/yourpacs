<?php
/**
Section Controler
@file section.class.php
@class Section
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

abstract class Section
{
	protected $doc;
	protected $docError;
	protected $primaryNode;

	public $error;

	/** ************************************************************************
	* Constructor
	*    - @param section string (Nombre de la seccion)
	***************************************************************************/
	function __construct($section = null)
	{
		# Init
		$this->error       = false;
		$this->docError    = null;

		$pkNode    = trim($section) ? strtolower(trim($section)) : "root";
		$this->doc = new BuildXML($pkNode);

		$this->primaryNode    = $pkNode;
	}

	/** ************************************************************************
	* setDebug:
	*   - Inserta en el debug el XML actual
	***************************************************************************/
	protected function setDebug()
	{
		if (Config::get("debug", "xmlallowed"))
		{
			$stringOrg = $this->doc->saveXML();
			$string = str_replace("<", "\n<", $stringOrg);
			$string = str_replace("\n</", "</", $string);
			$string = str_replace("></", ">\n</", $string);

			Debug::set(htmlentities($string), "XML {$this->code}");
		}
	}

	/** ************************************************************************
	* show:
	*   - Devuelve el XML
	*   - @return DOM Object
	***************************************************************************/
	protected function show()
	{
		# Comprobamos si hay errores
		if (!$this->error)
		{
			# Devolvemos el documento
			return $this->doc;
		}
		else
		{
			# Devolvemos el XML del error
			return $this->docError;
		}
	}

	/** ************************************************************************
	* setError:
	*   - Establece un error
	*   - @param doc DOM Object (XML con el error)
	***************************************************************************/
	protected function setError($doc)
	{
		$this->error    = true;
		$this->docError = $doc;
	}

	/** ************************************************************************
	* NOTE: Metodo abstracto
	* perform:
	*   - Metodo por defecto que devuelve la clase si no se especifica nada
	*   - Tiene que devolver: @return DOM object
	***************************************************************************/
	abstract public function perform();
}

