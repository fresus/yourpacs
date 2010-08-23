<?php
/**
BuildXML
@file buildXML.class.php
@class BuildXML
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


class BuildXML {

	private $doc;
	private $primaryNode;
	private $lastNode;
	private $lastParentNode;

	/** ************************************************************************
	* Constructor:
	*   - Requiere un tag padre.
	*   - @param primaryNode string
	***************************************************************************/
	function __construct($primaryNode = false) {
		$doc = new DOMDocument('1.0', 'utf-8');

		if ($primaryNode) {
			$node = $doc->createElement($primaryNode);
			$elem = $doc->appendChild($node);
		}

		$this->doc = $doc;
		$this->primaryNode = $elem;
	}

	/** ************************************************************************
	* load:
	*   - Carga un fichero XSL o XML dentro del documento
	*   - @param file string
	***************************************************************************/
	function load($file) {
		$this->doc->load($file);
	}

	/** ************************************************************************
	* searchNode:
	*   - Busca un nodo en el arbol y lo devuelve.
	*   - @param element string
	*   - @return DOMElement (object) | bool (false)
	***************************************************************************/
	function searchNode($element)
	{
		# Init
		$elem     = false;
		$element  = trim($element);
		$nodeList = $this->doc->getElementsByTagName($element);

		foreach ($nodeList as $elemento)
		{
			if ($elemento->nodeName == $element)
			{
				$elem = $elemento;
				break;
			}
		}

		return $elem;
	}

	/** ************************************************************************
	* appendNode:
	*   - A�de un nodo al arbol
	*   - @param node array assoc (Array con el nodo)
	*   - @param parent string | object (Nombre del nodo padre o un nodo)
	*   - @return bool
	***************************************************************************/
	function appendNode($node, $value = null, $atr = array(), $parent = null)
	{
		# Init
		$node   = trim($node);
		$parent = is_object($parent) ? $parent : trim($parent);

		# En caso de tener padre, lo buscamos
		if ($parent)
		{
			# Si el padre es un objeto, lo usamos de nodo
			if (is_object($parent)) {
				$elem = $parent;
			}
			else
			{
				$elem = $this->searchNode($parent);

				# Si el padre no existe, lo creamos
				#DOMElement
				if (!$elem)
				{
					$primary = $this->primaryNode;
					$newNode = $this->doc->createElement($parent);
					$elem    = $primary->appendChild($newNode);
				}
			}
		}
		# Si no tiene padre, le damos uno (el root)
		else {
			$elem = $this->primaryNode;
		}

		if ($elem)
		{
			$element = @$this->doc->createElement($node, $value);

			# Asignamos los atributos
			if (is_array($atr)) {
				foreach ($atr as $atrName => $atrValue) {
					@$element->setAttribute($atrName, $atrValue);
				}
			}

			return $elem->appendChild($element);
		}

		return false;
	}

	/** ************************************************************************
	* arrayToNodes:
	*   - Transforma un array associativo en un nodo con atributos e
	*     hijos y los a�de en la rama de "element".
	*   - @param arrayNodes Puede ser un array asociativo o un array
	*                       con dos elementos, la primera posicion
	*                       sera el array de nodos y la segunda la
	*                       rama del arbol.
	*
	*                       array[index][tag] = string
	*                       array[index][value] = string
	*                       array[index][atr] = array[name] = string
	*   - @param element string
	***************************************************************************/
	function arrayToNodes($arrayNodes, $element = false) {

		$doc = $this->doc;

		# Recorremos el array de Nodos
		foreach ($arrayNodes as $nodes) {

			if (is_array($nodes[0])) {
				$elem = $this->searchNode($nodes[1]);
				$nodes = $nodes[0];
			}
			else {
				$elem = $this->searchNode($element);
			}

			$node = $doc->createElement($nodes['tag'], $nodes['value']);

			# Asignamos los atributos
			if (is_array($nodes['atr'])) {
				foreach ($nodes['atr'] as $atrName => $atrValue) {
					$node->setAttribute($atrName, $atrValue);
				}
			}

			# Asignamos el nodo al elemento
			$elem->appendChild($node);
		}

		# Guardamos el documento
		$this->doc = $doc;
	}

	/** ************************************************************************
	* getDocument:
	*   - Devuelve el documento DOM
	*   - @param sin parametros.
	***************************************************************************/
	function getDocument() {
		return $this->doc;
	}

	/** ************************************************************************
	* saveXML:
	*   - Crea el documento en formato XML
	*   - @param sin parametros.
	***************************************************************************/
	function saveXML() {
		return $this->doc->saveXML();
	}

	/** ************************************************************************
	* saveHTML:
	*   - Crea el documento en formato HTML
	*   - @param sin parametros.
	***************************************************************************/
	function saveHTML() {
		return $this->doc->saveHTML();
	}

}

?>