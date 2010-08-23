<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="searchuser">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/</xsl:variable>

			<div class="bradius"> 
				<h1><xsl:value-of select="language/searchuser/title" /></h1>
				<br/>
				<xsl:value-of select="language/searchuser/desc" />
                <br/>
                <br/>
                <form name="search" method="post" action="">
                <xsl:value-of select="language/searchuser/search" /> 
                <input name="filter" type="text" value="{filter}" class="text"/><br />
                </form>
                <br/>

				<table width="100%" cellpadding="0" cellspacing="4">
                <xsl:if test="count(users/item) != 0" >
                    <tr>
                        <td><b><xsl:value-of select="language/searchuser/user" /></b></td>
                        <td><b><xsl:value-of select="language/searchuser/aet" /></b></td>
                        <td><b><xsl:value-of select="language/searchuser/ip" /></b></td>
                        <td><b><xsl:value-of select="language/searchuser/port" /></b></td>
                        <td></td>
                    </tr>
                </xsl:if>
				<xsl:for-each select="users/item">
					<tr>
						<td width="30%"><xsl:value-of select="@user" /></td>
						<td width="30%"><xsl:value-of select="@aet" /></td>
						<td width="20%"><xsl:value-of select="@ip" /></td>
						<td width="10%"><xsl:value-of select="@port" /></td>
					</tr>
				</xsl:for-each>

				</table> 
                <xsl:if test="(count(users/item) = 0) and (filter != '')" >
                <span class="error"><xsl:value-of select="language/searchuser/notfound" /></span>
                </xsl:if>
			</div>

	</xsl:template>

</xsl:stylesheet>
