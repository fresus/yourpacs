<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="ISO-8859-1"/>

	<xsl:template match="/*">

		<div class="error">
			<div class="description">
				<xsl:value-of select="//error/desc" />
			</div>

			<div class="return">
				<a href="{//error/url}" alt="" title="">Pulsa aquí para volver</a>
			</div>
		</div>

	</xsl:template>

</xsl:stylesheet>