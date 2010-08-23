<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<!-- Imports -->
	<xsl:import href="imports/head.xsl" />
	<xsl:import href="imports/header.xsl" />
	<xsl:import href="imports/footer.xsl" />

	<!-- Imports control panel -->
	<xsl:import href="controlpanel/home.xsl" />
	<xsl:import href="controlpanel/pacs.xsl" />
	<xsl:import href="controlpanel/studies.xsl" />
	<xsl:import href="controlpanel/payments.xsl" />
	<xsl:import href="controlpanel/searchuser.xsl" />
	<xsl:import href="controlpanel/invitation.xsl" />
	<xsl:import href="controlpanel/configaccount.xsl" />
	<xsl:import href="controlpanel/upgrade.xsl" />

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
				<td class="content controlpanel">
					<!-- ********************************************************
					******* START ***** CONTENT ***** START ***** CONTENT *******
					********************************************************* -->
                    <xsl:if test="accounttype = '0'">
					<div class="bradius">
                            <h1><a class="upgrade" href="{$url}help/yourpacspro"><xsl:value-of select="language/controlpanel/upgradeaccount" /></a></h1>
                            <xsl:value-of select="language/controlpanel/upgradeaccountdesc" />
                            <br /> 
					</div>
                        </xsl:if>

					<br/>

					<table width="100%" cellspacing="0">
					<tr>
						<td valign="top" style="padding-right: 10px; width: 190px;">
							<!-- Menu -->
							<div class="bradius">
								<h1><xsl:value-of select="language/controlpanel/menu" /></h1>
								<ul class="menu">
									<li><a href="{$url}controlpanel/home"><xsl:value-of select="language/controlpanel/home" /></a></li>
									<li><a href="{$url}controlpanel/pacs"><xsl:value-of select="language/controlpanel/pacs" /></a></li>
									<li><a href="{$url}controlpanel/searchuser"><xsl:value-of select="language/controlpanel/search" /></a></li>
									<li><a href="{$url}controlpanel/configaccount"><xsl:value-of select="language/controlpanel/configaccount" /></a></li>
									<li><a href="{$url}controlpanel/invitation"><xsl:value-of select="language/controlpanel/invitation" /></a></li>
                                    <li><a href="/wiki"><xsl:value-of select="language/controlpanel/documentation" /></a></li>
					<!--				<li><a href="{$url}controlpanel/logaccess"><xsl:value-of select="language/controlpanel/logaccess" /></a></li> -->
								</ul>
                                <br/>
							</div>

							<br/>
						</td>
						<td valign="top">
							<xsl:if test="keycp = 'home'">
								<xsl:call-template name="home" />
							</xsl:if>

							<xsl:if test="keycp = 'pacs'">
								<xsl:call-template name="pacs" />
							</xsl:if>

						    <!--	
                            <xsl:if test="keycp = 'payments'">
								<xsl:call-template name="payments" />
							</xsl:if> 
                            -->
							
                            <xsl:if test="keycp = 'upgrade'">
								<xsl:call-template name="upgrade" />
							</xsl:if>

							<xsl:if test="keycp = 'searchuser'">
								<xsl:call-template name="searchuser" />
							</xsl:if>

							<xsl:if test="keycp = 'invitation'">
								<xsl:call-template name="invitation" />
							</xsl:if>

							<xsl:if test="keycp = 'configaccount'">
								<xsl:call-template name="configaccount" />
							</xsl:if>

							<xsl:if test="keycp = 'logaccess'">
								<div class="bradius">
									<h1><xsl:value-of select="language/controlpanel/titleaccess" /></h1>

									<div class="logaccess">
										<ul>
											<xsl:for-each select="logaccess/item">
												<li>(<xsl:value-of select="@date" />) <xsl:value-of select="." /></li>
											</xsl:for-each>
										</ul>

										<xsl:if test="count(logaccess/item) = 0">
											<xsl:value-of select="language/controlpanel/nologaccess" />
										</xsl:if>
										<br />
									</div>
								</div>
							</xsl:if>
						</td>
					</tr>

    				<!-- Utilizar pacs -->
					<xsl:if test="keycp = 'pacs'">
                    <tr>
                        <td colspan="2" style="padding-top: 15px;">
					        <xsl:call-template name="studies" />
                        </td>
                    </tr>
					</xsl:if>

					</table>
					<!-- ********************************************************
					********* END ***** CONTENT ***** END ***** CONTENT *********
					********************************************************* -->
					<br style="clear: both;" />
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
