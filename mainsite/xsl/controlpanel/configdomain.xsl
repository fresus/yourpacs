<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="configdomain">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

			<div class="bradius"><div><div><div><div><div><div><div>
				<h1><xsl:value-of select="language/controlpanel/configdomaintitle" /></h1>
				<p><xsl:value-of select="language/controlpanel/configdomaindesc" />
					<xsl:text> </xsl:text>
					<a href="http://{user/login}.lynksee.com"><xsl:value-of select="user/login" />.lynksee.com</a>
				</p>
				<br/>
				<span style="font-size: 9px;">Ej.: domain.com, www.domain.com, www.domain.com.ar</span>
				<br/><br/>

				<form name="formConfigDomain" action="" method="post">

					<xsl:value-of select="language/controlpanel/domain" /><br/>
					<input type="text" name="domain" value="{configdomain/domain}" class="text" />

					<br/><br/>

					<input id="deletedomain" type="checkbox" name="deletedomain" value="1" />
					<xsl:text> </xsl:text>
					<xsl:value-of select="language/controlpanel/deletedomain" />

					<div style="text-align: right; padding: 10px;">
						<span class="error"><xsl:value-of select="configdomain/error" /></span>
						<span class="success"><xsl:value-of select="configdomain/success" /></span>
						&amp;nbsp;&amp;nbsp;
						<input type="button" value="{language/general/save}" class="bsubmit" onclick="checkDeleteDomainConfirm('deletedomain', '{language/controlpanel/configdomainconfirm}');" />
					</div>

				</form>
			</div></div></div></div></div></div></div></div>

	</xsl:template>

</xsl:stylesheet>
