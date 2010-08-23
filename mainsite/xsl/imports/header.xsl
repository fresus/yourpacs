<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>

	<xsl:template name="header">

		<!-- Variables -->
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="url">/<xsl:value-of select="//page/acronym" />/</xsl:variable>

		<div class="header">
			<div class="logo"><a href="{$url}"><img src="{$img}logo.png" alt="Logo" title="Yourpacs" /></a></div>
			<div class="name">
				<div><span class="super">YourPACS</span></div>
				<div class="beta">beta <span class="version"></span></div>
			</div>

			<div class="headerright">
				<div class="bradius" style="height: 75px;">

					<!-- Auth -->
					<xsl:if test="user/id != 0">
						<h2><xsl:value-of select="language/header/welcome" /><xsl:text> </xsl:text><xsl:value-of select="user/login" /></h2>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="1%"><img src="{$img}settings.png" alt="" title="" align="left" /></td>
							<td><a href="{$url}controlpanel"><xsl:value-of select="language/header/gotocpanel" /></a></td>
						</tr>
						<tr>
							<td><img src="{$img}exit.png" alt="" title="" align="left" /></td>
							<td><a href="{$url}login%26disconnect=true"><xsl:value-of select="language/header/disconnect" /></a></td>
						</tr>
						</table>
					</xsl:if>

					<!-- NO Auth -->
					<xsl:if test="user/id = 0">
						<h2><xsl:value-of select="language/header/enteryourpacs"/></h2>
						<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="1%"><img src="{$img}enter2.png" alt="" title="" align="left" /></td>
							<td><a href="{$url}newaccount"><xsl:value-of select="language/header/newaccount" /></a></td>
						</tr>
						<tr>
							<td><img src="{$img}enter.png" alt="" title="" align="left" /></td>
							<td><a href="{$url}login"><xsl:value-of select="language/header/haveaccount" /></a></td>
						</tr>
						</table>

			    <!--		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
						<script type="text/javascript">
							_uacct = "UA-2205502-1";
							_udn="lynksee.com";
							urchinTracker();
						</script> -->
					</xsl:if>
			</div>
        	</div>
		</div>
    	<div class="line">
    		 <table width="790" cellpadding="0" cellspacing="0" border="0" align="center">
    		 <tr>
			 	 <td class="options">
                     | <a href="{$url}home"><xsl:value-of select="language/controlpanel/home" /></a>
				 	 | <a href="{$url}help/whatis"><xsl:value-of select="language/sections/whatis" /></a>
					 | <a href="{$url}help/sothat"><xsl:value-of select="language/sections/sothat" /></a>
					 | <a href="{$url}help/faq"><xsl:value-of select="language/sections/faq" /></a>
					 | <a href="/wiki/"><xsl:value-of select="language/sections/doc" /></a>
					 | <a href="{$url}contact"><xsl:value-of select="language/sections/contact" /></a>
					 |
				 </td>
			 	 <td class="lang"><span><xsl:value-of select="language/header/language" />&amp;nbsp;</span>
					<select name="language" id="langselector" onchange="selectlang(this.value)">
						<xsl:for-each select="languages/item">
							<xsl:if test="//page/acronym = @acronym">
								<option value="/{@acronym}/{//section}" selected="true"><xsl:value-of select="." /></option>
							</xsl:if>
							<xsl:if test="//page/acronym != @acronym">
								<option value="/{@acronym}/{//section}"><xsl:value-of select="." /></option>
							</xsl:if>
						</xsl:for-each>
					</select>
    			 </td>
    		 </tr>
    		 </table>
		</div>

	</xsl:template>

</xsl:stylesheet>
