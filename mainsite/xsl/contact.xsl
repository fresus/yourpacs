<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<!-- Imports -->
	<xsl:import href="imports/head.xsl" />
	<xsl:import href="imports/header.xsl" />
	<xsl:import href="imports/footer.xsl" />

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template match="/*">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="//page/acronym" />/</xsl:variable>

		<![CDATA[<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">]]>
		<html>
		<head>
			<!-- Head -->
			<xsl:call-template name="head" />
        </head>

		<body>
			<table width="790" cellpadding="0" cellspacing="0" border="0" align="center" class="main">
			<tr>
				<td class="header">
					<!-- Header -->
					<xsl:call-template name="header" />
				</td>
			</tr>
			<tr>
				<td class="content contact">
					<!-- ********************************************************
					******* START ***** CONTENT ***** START ***** CONTENT *******
					********************************************************* -->
					<div class="bradius">
						<h1><xsl:value-of select="language/contact/title" /></h1>

						<xsl:if test="success = 1">
							<p><xsl:value-of select="language/contact/success" /></p>
							<br/>
						</xsl:if>

						<xsl:if test="success = 0">
							<p><xsl:value-of select="language/contact/text_new" /></p>
							<br/>
							<p>
								<form name="contact" method="post" action="">
									<xsl:if test="user/id = 0">
										<xsl:value-of select="language/contact/email" /><br />
										<input name="email" type="text" value="{email}" class="{email/@class}"/> <span class="error"><xsl:value-of select="email/@error" /></span><br />
										<br />
									</xsl:if>
									<xsl:value-of select="language/contact/message" /><br />
									<textarea name="text" class="{text/@class}"><xsl:value-of select="text" /></textarea>
									<span class="error"><xsl:value-of select="text/@error" /></span>

									<br/><br/>
									<input type="submit" value="{language/general/send}" class="bsubmit" />
									<br /><br/>
								</form>
							</p>
						</xsl:if>
					</div>
					<!-- ********************************************************
					********* END ***** CONTENT ***** END ***** CONTENT *********
					********************************************************* -->
				</td>
			</tr>
			<tr>
				<td class="footer">
					<!-- Footer -->
					<xsl:call-template name="footer" />
				</td>
			</tr>
			</table>
		</body>
		</html>

	</xsl:template>

</xsl:stylesheet>
