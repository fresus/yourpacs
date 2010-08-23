<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>

	<xsl:template name="head">

		<!-- Variables -->
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="js" select="path/js" />

		<meta content="text/html; charset=UTF-8" http-equiv="Content-type" />
    	<title><xsl:value-of select="page/title" /></title>

    	<link rel="shortcut icon" href="{$img}fabicon.ico" type="image/x-icon"/>

		<!-- Estilos -->
		<xsl:for-each select="styles/item">
			<link rel="stylesheet" type="text/css" href="{$css}{.}?version={@version}" />
		</xsl:for-each>

		<!-- JavaScript -->
		<script type="text/javascript" src="{$js}utils.js?version={@version}"></script>
		<script type="text/javascript" src="{$js}jquery.js"></script>
        <script type="text/javascript" src="{$js}curvycorners.js"></script> 
		<script type="text/javascript" src="{$js}jquery_main.js"></script>
		<xsl:for-each select="javascript/item">
			<script type="text/javascript" src="{$js}{.}?version={@version}"></script>
		</xsl:for-each>


	</xsl:template>

</xsl:stylesheet>
