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
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

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
				<td class="content newaccount">
					<!-- ********************************************************
					******* START ***** CONTENT ***** START ***** CONTENT *******
					********************************************************* -->
					<div class="bradius">
						<h1><xsl:value-of select="language/newaccount/desctitle" /></h1>
						<xsl:value-of select="language/newaccount/desc" />
					</div>

					<br/>

					<div class="bradius">
						<form id="fnewaccount" name="newaccount" action="{$url}createaccount" method="post" >
							<div class="stepcontent">
								<div><xsl:value-of select="language/newaccount/name" /></div>
								<input class="text" type="text" name="account" id="account" maxlength="16" />  <span class="error" id="accounterror"></span>
								<div class="separator"></div>

								<div class="col"><xsl:value-of select="language/newaccount/email" /></div><div class="col"><xsl:value-of select="language/newaccount/cemail" /></div>
								<br style="clear:both;"/>
								<input class="text" type="text" name="email" id="email" /> <input class="text" type="text" name="cemail" id="cemail" /> <span class="error" id="emailerror"></span>
								<div class="separator"></div>

								<div class="col"><xsl:value-of select="language/newaccount/password" /></div><div class="col"><xsl:value-of select="language/newaccount/cpassword" /></div>
								<br style="clear:both;"/>
								<input class="text" type="password" name="passwd" id="passwd" /> <input class="text" type="password" name="cpasswd" id="cpasswd" /> <span class="error" id="passwderror"></span>
								<div class="separator"></div>

								<div class="col"><xsl:value-of select="language/newaccount/captcha" /></div>
								<br style="clear:both;"/>
								<img src="/captcha.php" alt="" title="" class="captcha" /> <input class="captcha" type="text" name="captcha" id="captcha" maxlength="6"/> <span class="error" id="captchaerror"></span>
							</div>

							<div class="stepcontent">
								<input id="terms" type="checkbox" name="acceptterms" value="1" /><xsl:text> </xsl:text>
								<span><xsl:value-of select="language/newaccount/acceptthe" /></span><xsl:text> </xsl:text>
								<a href="{$url}help/license"><xsl:value-of select="language/newaccount/terms" /></a><xsl:text> </xsl:text>
								<span><xsl:value-of select="language/newaccount/oflynksee" /></span>
								&amp;nbsp;&amp;nbsp;&amp;nbsp;<span class="error" id="termserror"></span>
								<br />
								<br />
								<input type="button" value="{language/general/accept}" class="bsubmit" onclick="testFields('{page/acronym}', {texterror});" />
							</div>
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
