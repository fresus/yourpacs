<?php
/**
BuildHTML
@file buildHTML.class.php
@class BuildHTML
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


class BuildHTML
{
	private $xsl;
	private $xml;

	private $proc;

	/** ************************************************************************
	* Constructor:
	*   - @param xsl string (fichero XSLT)
	*   - @param xml DOM object (Objeto XML)
	***************************************************************************/
	function __construct($xsl, $xml)
	{
		# Init
		$this->xsl = trim($xsl);
		$this->xml = $xml;
	}

	/** ************************************************************************
	* getHTML:
	*   - Crea el documento en formato HTML
	*   - @param mode string (Modo de retorno)
	***************************************************************************/
	function getHTML($mode = "html", $ajax = false)
	{
		# Creamos el path del XSL
		$fileXsl = Config::get("path", "xsl") . "/{$this->xsl}.xsl";

		# Juntamos el XSL con el XML
		$xsl = new DOMDocument('1.0', 'utf-8');
		$xsl->load($fileXsl);

		# Configura y prepara el Transformador
		$this->proc = new XSLTProcessor;
		$this->proc->importStyleSheet($xsl); #A�adimos el XSL

		if ($mode == "xml")
		{
			header("Content-type: text/xml");
			return $this->xml->saveXML();
		}

		return html_entity_decode($this->proc->transformToDoc($this->xml)->saveHTML());
	}

}

?>