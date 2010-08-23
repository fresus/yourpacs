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
				<td class="content login">
					<!-- ********************************************************
					******* START ***** CONTENT ***** START ***** CONTENT *******
					********************************************************* -->
					<div class="bradius">
						<form name="" action="" method="post">
							<h1><xsl:value-of select="language/login/enterl" /></h1>
							<div><xsl:value-of select="language/newaccount/name" /></div>
							<div><input type="text" name="account" value="{account}" class="{account/@class}" />  <span class="error"><xsl:value-of select="account/@error" /></span></div>
							<br/>
							<div><xsl:value-of select="language/newaccount/password" /></div>
							<div><input type="password" name="passwd" value="" class="{passwd/@class}" />  <span class="error"><xsl:value-of select="passwd/@error" /></span></div>
							<br/>
							<div><input type="submit" value="Entrar" class="bsubmit" /></div>
							<br/>
						</form>
					</div>

					<br/>

					<div class="bradius">
						<form name="recoverpass" action="" method="post">
							<h1><xsl:value-of select="language/login/recoverpass" /></h1>
							<div><xsl:value-of select="language/newaccount/email" /></div>
							<div><input type="text" name="email" value="{email}" class="text" /></div>
							<br/>
							<div>
								<input type="submit" value="Recuperar" class="bsubmit" />
								<xsl:if test="success = 1">
									<xsl:text> </xsl:text>
									<span class="success"><xsl:value-of select="language/login/sentcode" /></span>
								</xsl:if>
								<xsl:if test="error = 1">
									<xsl:text> </xsl:text>
									<span class="error"><xsl:value-of select="language/login/emailnoexists" /></span>
								</xsl:if>
							</div>
							<br/>
						</form>
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
