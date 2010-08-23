<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>

	<xsl:template name="footer">

		<!-- Variables -->
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="url">/<xsl:value-of select="//page/acronym" />/</xsl:variable>

		<div class="footer">
			<a href="{$url}help/license"><xsl:value-of select="language/footer/license" /></a>
			<xsl:text> </xsl:text>
			<xsl:value-of select="language/footer/copy" />
			<xsl:text> </xsl:text>

			(<xsl:for-each select="languages/item">
				<a href="/{@acronym}/"><xsl:value-of select="." /></a>
				<xsl:if test="position() != count(//languages/item)">
				<xsl:text> | </xsl:text>
				</xsl:if>
			</xsl:for-each>)
			<br/>
			<xsl:value-of select="language/footer/info" />
		</div>

	</xsl:template>

</xsl:stylesheet>
