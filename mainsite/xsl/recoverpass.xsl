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
				<td class="content recoverpass">
					<!-- ********************************************************
					******* START ***** CONTENT ***** START ***** CONTENT *******
					********************************************************* -->
					<div class="bradius">

						<xsl:if test="hasherror != 0">
							<div class="hasherror"><xsl:value-of select="hasherror" /></div>
						</xsl:if>

						<xsl:if test="hasherror = 0">
							<form name="recover" action="" method="post">
								<input type="hidden" name="hash" value="{hash}" />

								<h1><xsl:value-of select="language/login/changepass" /></h1>
								<div><xsl:value-of select="language/newaccount/name" /></div>
								<div><input type="text" name="account" value="{account}" class="{account/@class}" />  <span class="error"><xsl:value-of select="account/@error" /></span></div>
								<br/>

								<div class="col"><xsl:value-of select="language/newaccount/password" /></div><div class="col"><xsl:value-of select="language/newaccount/cpassword" /></div>
								<br style="clear:both;"/>
								<input type="password" name="passwd" class="{passwd/@class}" value="{passwd}" /> <input type="password" name="cpasswd" class="{passwd/@class}" value="{passwd}" /> <span class="error"><xsl:value-of select="passwd/@error" /></span>
								<div class="separator"></div>

								<div><input type="submit" value="{language/login/change}" class="bsubmit" /></div>
								<br/>
							</form>
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
