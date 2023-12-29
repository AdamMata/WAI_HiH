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
						<th></th>
						<th>Autor</th>
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
			<td>
				<xsl:call-template name="name-as-link">
					<xsl:with-param name="name" select="./contributors/publisher/text()"/>
					<xsl:with-param name="link" select="./contributors/publisher/link"/>
				</xsl:call-template>
			</td>
			<td>
				<xsl:value-of select="./contributors/release"/> <!--TODO-->
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

		<xsl:call-template name="name-as-link">
			<xsl:with-param name="name" select="text()"/>
			<xsl:with-param name="link" select="./link"/>
		</xsl:call-template>		

	</xsl:template>

	<xsl:template name="name-as-link">
		<xsl:param name="name"/>
		<xsl:param name="link"/>
		<xsl:choose>
			<xsl:when test="$link != ''">
				<xsl:element name="a">
					<xsl:attribute name="href">
						<xsl:value-of select="$link"/>
					</xsl:attribute>
					<xsl:value-of select="$name"/>
				</xsl:element>
			</xsl:when> 
			<xsl:otherwise>
				<xsl:value-of select="$name"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>
