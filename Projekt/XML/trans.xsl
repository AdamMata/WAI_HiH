<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/">
		<html>
			<head>
				<link rel="stylesheet" href="styles.css"/>
			</head>	
			<body>
				<h1>Gry</h1>
				<table>
					<tr>
						<th>Tytuł</th>
						<th>Logo</th>
						<th>Studio</th>
						<th>Wydawca</th>
						<th>Data wydania</th>
						<th>Wymagania</th>
						<th>Silnik</th>
						<th>Gatunek</th>
					</tr>
					<xsl:apply-templates select="games/game"/>
				</table>
			</body>

		</html>
	</xsl:template>

	<xsl:template match="game">
		<tr>
			<xsl:element name="td">
				<xsl:value-of select="@title"/>
			</xsl:element>
			<td>
				<xsl:element name="img">
					<xsl:attribute name="src">
						<xsl:value-of select="image[@type='logo']"/>
					</xsl:attribute>
					<xsl:attribute name="height">
						20
					</xsl:attribute>
				</xsl:element>
			</td>
			<td>
				<xsl:apply-templates select="contributors"/>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="contributors">
			<xsl:apply-templates select="author"/>
	</xsl:template>

	<xsl:template match="author">
		<xsl:element name="span">
			<xsl:attribute name="class">
				author-type
			</xsl:attribute>
			<xsl:value-of select="@type"/>
		</xsl:element>
		<xsl:value-of select="text()"/>
		<xsl:variable name="link" select="./link"/>
		<xsl:if test="link != ''">
			<xsl:element name="a">
				<xsl:attribute name="href">
					<xsl:value-of select="./link"/>
				</xsl:attribute>
				link
			</xsl:element>
		</xsl:if>

	</xsl:template>
</xsl:stylesheet>
