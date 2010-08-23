<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="upgrade">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

	    <div class="bradius">
            <xsl:if test="accounttype = '0'">
    	    	<h1><xsl:value-of select="language/controlpanel/upgradetitle" /></h1>
                <br />
	        	<xsl:value-of select="language/controlpanel/upgradedesc" />
                <br />
                <br />

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----" />
<input type="submit" value="Contratar" class="bsubmit" />
</form>
 
<!--                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick-subscriptions" />
                <input type="hidden" name="business" value="JHB4QPPU48KEE" />
                <input type="hidden" name="lc" value="ES" />
                <input type="hidden" name="item_name" value="Yourpacs PRO" />
                <input type="hidden" name="a3" value="44.00" />
                <input type="hidden" name="currency_code" value="EUR" />
                <input type="hidden" name="src" value="1" />
                <input type="hidden" name="p3" value="1" />
                <input type="hidden" name="t3" value="M" />
                <input type="hidden" name="sra" value="1" />
                <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted" />
                <input type="submit" value="Contratar" class="bsubmit" />
                </form> -->
                <br />
            </xsl:if>
            <xsl:if test="accounttype = '1'">
    	    	<h1><xsl:value-of select="language/controlpanel/downgradeaccount" /></h1>
                <br />
	        	<xsl:value-of select="language/controlpanel/downgradeaccountdesc" />
                <br />
                <br />
                <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&amp;alias=JHB4QPPU48KEE">
                    <input type="submit" value="Baja" class="bsubmit" /> 
                </a>
                <br />
                <br />
            </xsl:if>
	    </div>

	</xsl:template>
</xsl:stylesheet>
