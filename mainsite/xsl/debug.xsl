<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>

	<xsl:template match="/*">

		<script type="text/javascript" src="{path/js}debug.js?version={path/js/@version}"></script>

		<xsl:for-each select="item">
			<div class="contenedor"
				 style="position: absolute;
				 		border: 1px solid grey;
				 		background: #FFCCCC;
				 		opacity: 0.90;
				 		top: 50px;
				 		left: 10px;
				 		min-width: 200px;
				 		text-align: left;
				 		">
				<div class="movible"
					style="cursor: move;
						   font-size: 11px;
						   width: 98%;
						   height: 16px;
						   background: #CCCCCC;
						   padding-left: 4px;
						   text-align: left;
						   "
					onmousedown="clickCapa(event, this)"
					onmouseup="liberaCapa()"
					ondblclick="esconder(this.parentNode)">
					<b><xsl:value-of select="@title" /></b>
						[<span style="cursor: pointer; text-decoration: underline;"
							   onclick="esconder(this.parentNode.parentNode)">Esconder</span> |
						<span style="cursor: pointer; text-decoration: underline;"
							   onclick="cerrar(this.parentNode.parentNode)"> Cerrar</span>]
				</div>
				<pre style="padding: 10px; font-size: 11px;"><xsl:value-of select="." /></pre>
			</div>
		</xsl:for-each>

	</xsl:template>

</xsl:stylesheet>