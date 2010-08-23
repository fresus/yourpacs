<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="home">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

			<div class="bradius">
                <h1><xsl:value-of select="language/controlpanel/desctitle" /></h1>
                <xsl:if test="accounttype = 0 and demo = 1">
                    <xsl:value-of select="language/controlpanel/stilldemo" />
                    <strong><xsl:value-of select="regdate" /></strong>
                </xsl:if>

                <xsl:if test="accounttype = 0 and demo = 0">
                    <xsl:value-of select="language/controlpanel/stopdemo" />
                </xsl:if>
                <br/>
                <br/>
                <xsl:value-of select="language/controlpanel/desc" />
			</div>

	</xsl:template>

</xsl:stylesheet>
