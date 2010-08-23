<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="ISO-8859-1"/>

	<xsl:template match="/*">

		<ul>
			<xsl:for-each select="listmenu/item">
				<xsl:if test="@selected = 1">
					<li class="active"><a href="{@url}"><xsl:value-of select="." /></a></li>
				</xsl:if>
				<xsl:if test="@selected = 0">
					<li><a href="{@url}"><xsl:value-of select="." /></a></li>
				</xsl:if>
			</xsl:for-each>
		</ul>

	</xsl:template>

</xsl:stylesheet>