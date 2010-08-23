<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="payments">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

	    <div class="bradius">
	    	<h1><xsl:value-of select="language/controlpanel/titlepayments" /></h1>
            <br />
	    	<div class="logaccess">
	    		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	    			<xsl:for-each select="payments/item">
                    <tr>
	    				<td>(<xsl:value-of select="@date" />)</td> 
                        <td><xsl:value-of select="@concept" /></td> 
                        <xsl:if test="@currency = '0'">
                            <td><xsl:value-of select="@ammount" />&#8364;</td>
                        </xsl:if>
                        <xsl:if test="@currency = '1'">
                            <td><xsl:value-of select="@ammount" />$</td>
                        </xsl:if>
                    </tr>
	    			</xsl:for-each>
	    		</table>

	    		<xsl:if test="count(payments/item) = 0">
	    			<xsl:value-of select="language/controlpanel/nopayments" />
	    		</xsl:if>
	    		<br />
	    	</div>
	    </div>

	</xsl:template>
</xsl:stylesheet>
