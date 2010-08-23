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
				<td class="content userlist">
					<!-- ********************************************************
					******* START ***** CONTENT ***** START ***** CONTENT *******
					********************************************************* -->
					<div class="bradius">
						<h1><xsl:value-of select="language/userlist/title" /></h1>
						<p><xsl:value-of select="language/userlist/desc" /></p>
						<br/>

						<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td valign="top">
								<xsl:for-each select="thematic/item">
									<xsl:if test="count(useritem) >= 1">

										<xsl:if test="@num = 1">
											<![CDATA[</td><td valign="top">]]>
										</xsl:if>

										<div class="thematic">
											<h2><xsl:value-of select="@name" /></h2>
											<xsl:for-each select="useritem">
												<a href="http://{.}.lynksee.com/blog"><img src="{$img}ico_page.png" alt="Blog" title="Blog" /></a>
												<xsl:text> </xsl:text>
												<a href="http://{.}.lynksee.com/blog/?feed=rss2"><img src="{$img}ico_rss.png" alt="Rss" title="Rss" /></a>
												<xsl:text> </xsl:text>
												<a href="http://{.}.lynksee.com"><xsl:value-of select="." /></a><br/>
											</xsl:for-each>
										</div>

									</xsl:if>

								</xsl:for-each>
							</td>
						</tr>
						</table>

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
