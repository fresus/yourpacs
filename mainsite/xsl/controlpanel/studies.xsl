<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template name="studies">

		<!-- Variables -->
		<xsl:variable name="css" select="path/css" />
		<xsl:variable name="img" select="path/img" />
		<xsl:variable name="js"  select="path/js"  />
		<xsl:variable name="url">/<xsl:value-of select="page/acronym" />/controlpanel/pacs</xsl:variable>
		<xsl:variable name="urlp">/<xsl:value-of select="page/acronym" />/controlpanel/pacs&amp;page=<xsl:value-of select="curr" /></xsl:variable>

			<div class="bradius"> 
                <h1><xsl:value-of select="language/studies/title"/></h1>
                <table width="100%" border="0">
                <tr>
                <form method="post" action="">
                    <td><input name="name" type="text" value="{fname}" class="text"/></td>
                    <td><input name="desc" type="text" value="{fdesc}" class="text"/></td>
                    <td><input type="submit" value="Filter"/></td>
                    <td></td>
                    <td></td>
                </form>
                </tr>
                <tr><td><b><xsl:value-of select="language/studies/patientname"/></b></td>
                    <td><b><xsl:value-of select="language/studies/studydesc"/></b></td>
                    <td><b><xsl:value-of select="language/studies/studytype"/></b></td>
                    <td><b><xsl:value-of select="language/studies/studydate"/></b></td>
                    <td></td>
                </tr>
                    <xsl:for-each select="studies/item">
                <tr>
                    <td><xsl:value-of select="@pat_name" /></td>
                    <td><xsl:value-of select="@study_desc" /></td>
                    <td><xsl:value-of select="@study_type" /></td>
                    <td><xsl:value-of select="@date" /></td>
                    <td><a href="{$urlp}&amp;del={.}" onclick="return confirm('Are you sure?')">delete</a></td>
                </tr>
                    </xsl:for-each>
                </table>
                <div style="margin-top: 10px;">
                <a style="margin-left: 300px;" href="{$url}&amp;page={prev}&amp;name={fname}&amp;desc={fdesc}"><img src="/img/arrow-left.png"/></a>
                <a style="margin-left: 100px;" href="{$url}&amp;page={next}&amp;name={fname}&amp;desc={fdesc}"><img src="/img/arrow-right.png"/></a>
                </div>
			</div>

	</xsl:template>

</xsl:stylesheet>
