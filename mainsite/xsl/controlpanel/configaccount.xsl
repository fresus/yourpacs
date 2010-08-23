<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="configaccount">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

                                <div class="bradius">
                                    <h1><xsl:value-of select="language/controlpanel/configaccount" /></h1>

                                    <form name="form" action="" method="post">
                                        <div class="col2"><xsl:value-of select="language/newaccount/email" /></div><div class="col2"><xsl:value-of select="language/newaccount/cemail" /></div>
                                        <br style="clear:both;"/>
                                        <input class="{email/@class}" type="text" name="email" value="{email}" /> <input class="{cemail/@class}" type="text" name="cemail" value="{cemail}" />
                                        <div class="separator"></div>

                                        <div class="col2"><xsl:value-of select="language/newaccount/password" /></div><div class="col2"><xsl:value-of select="language/newaccount/cpassword" /></div>
                                        <br style="clear:both;"/>
                                        <input class="{passwd/@class}" type="password" name="passwd" value="{passwd}" /> <input class="{cpasswd/@class}" type="password" name="cpasswd" value="{cpasswd}" />
                                        <div class="separator"></div>
                                        <div class="separator"></div>

                                        <xsl:if test="accounttype = 1">
                                           <a href="{url}upgrade"><xsl:value-of select="language/controlpanel/downgradeaccount" /></a>
                                        </xsl:if>
                                        <xsl:if test="accounttype = 0">
                                           <a href="{url}upgrade"><xsl:value-of select="language/controlpanel/upgradeaccount" /></a>
                                        </xsl:if>
                                        <br/>
                                        <br/>

                                        <xsl:if test="checknewsmail = 1">
                                            <input type="checkbox" name="newsmail" value="1" checked="checked" />
                                        </xsl:if>
                                        <xsl:if test="checknewsmail = 0">
                                            <input type="checkbox" name="newsmail" value="1" />
                                        </xsl:if>
                                        <xsl:text> </xsl:text>
                                        <xsl:value-of select="language/controlpanel/newsmail" /><br/><br/>

                                        <div style="text-align: right; padding: 10px;">
                                            <span class="error"><xsl:value-of select="error" /></span>
                                            <span class="success"><xsl:value-of select="success" /></span>
                                            &amp;nbsp;&amp;nbsp
                                            <input type="submit" value="{language/general/save}" class="bsubmit" />
                                        </div>
                                    </form>
                                </div>

	</xsl:template>

</xsl:stylesheet>
