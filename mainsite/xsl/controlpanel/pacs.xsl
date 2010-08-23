<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="pacs">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

			<div class="bradius"> 
                <h1><xsl:value-of select="language/pacs/title" /></h1>
                <br/>
            <xsl:if test="accounttype = 0">
                <xsl:value-of select="language/pacs/desc_free" />
            </xsl:if>

            <xsl:if test="accounttype = 1">
                <xsl:value-of select="language/pacs/desc_pro" />
            </xsl:if>
                <br/>
                <br/>
                <h2><xsl:value-of select="language/pacs/client" /></h2>
				<strong><xsl:value-of select="language/pacs/aet" /></strong><xsl:text> </xsl:text><xsl:value-of select="client/aet" /><br/>
				<strong><xsl:value-of select="language/pacs/port" /></strong><xsl:text> </xsl:text><xsl:value-of select="client/port" /><br/>
                <br/>
            <xsl:if test="accounttype = 1 or demo = 1">
                <h2><xsl:value-of select="language/pacs/server" /></h2>
				<strong><xsl:value-of select="language/pacs/aet" /></strong><xsl:text> </xsl:text><xsl:value-of select="server/aet" /><br/>
				<strong><xsl:value-of select="language/pacs/ip" /></strong><xsl:text> </xsl:text><xsl:value-of select="server/ip" /><br/>
				<strong><xsl:value-of select="language/pacs/port" /></strong><xsl:text> </xsl:text><xsl:value-of select="server/port" />
				<br/><br/>
            </xsl:if>
			</div>

	</xsl:template>

</xsl:stylesheet>
