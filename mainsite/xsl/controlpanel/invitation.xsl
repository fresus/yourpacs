<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="invitation">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

			<div class="bradius"> 
				<h1><xsl:value-of select="language/invitation/title" /></h1>
                <br />
				<p><xsl:value-of select="language/invitation/desc" /></p>
				<br/>
				<p>
					<form name="invitation" method="post" action="">
						<xsl:value-of select="language/general/email" /><br />
						<input name="email" type="text" value="" class="{email/@class}"/> <span class="error"><xsl:value-of select="error" /></span><br />
						<br />
						<span class="error"><xsl:value-of select="email/@error" /></span>
						<br/>
						<input type="submit" value="{language/general/send}" class="bsubmit" />
						<br /><br/>
					</form>
				</p>
				<xsl:if test="success = 1">
					<p style="color:green;font-weight:bold;"><xsl:value-of select="language/invitation/success" /></p>
					<br/>
				</xsl:if>
			</div>

	</xsl:template>

</xsl:stylesheet>
