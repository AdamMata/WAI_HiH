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
				</xsl:element>
			</td>
			<td>
				<xsl:apply-templates select="contributors/author"/>
			</td>
			<td>
				<xsl:call-template name="name-as-link">
					<xsl:with-param name="name" select="./contributors/publisher/text()"/>
					<xsl:with-param name="link" select="./contributors/publisher/link"/>
				</xsl:call-template>
			</td>
			<td>
				<xsl:apply-templates select="contributors/release"/>
				<!-- <xsl:value-of select="./contributors/release[@stage='full']"/> -->
			</td>
			<td>
				<ul>
					<xsl:apply-templates select="requirements/platforms/platform"/>
				</ul>
			</td>
			<td>
				<ul>
					<xsl:apply-templates select="genres/genre"/>
				</ul>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="author">
		<xsl:element name="span">
			<xsl:attribute name="class">
				type
			</xsl:attribute>
			<xsl:value-of select="@type"/>
		</xsl:element>

		<xsl:call-template name="name-as-link">
			<xsl:with-param name="name" select="text()"/>
			<xsl:with-param name="link" select="./link"/>
		</xsl:call-template>		

	</xsl:template>

	<xsl:template match="release">
		<xsl:choose>
			<xsl:when test="@stage='full'">
				<xsl:value-of select="."/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:element name="span">
					<xsl:attribute name="class">
						type
					</xsl:attribute>
					<xsl:value-of select="@stage"/>
				</xsl:element>
			</xsl:otherwise>
		</xsl:choose> 
	</xsl:template>

	<xsl:template match="platform">
		<xsl:element name="li">
			<xsl:attribute name="class">
				platform
			</xsl:attribute>
			<xsl:value-of select="@system"/>
			<xsl:text> </xsl:text>
			<xsl:value-of select="."/>
		</xsl:element>
	</xsl:template>

	<xsl:template match="genre">
		<xsl:element name="li">
			<xsl:attribute name="class">
				genre
			</xsl:attribute>
			<xsl:element name="span">
				<xsl:attribute name="class">
					type
				</xsl:attribute>
				<xsl:value-of select="@category"/>
			</xsl:element>
			<xsl:text> </xsl:text>
			<xsl:value-of select="."/>
		</xsl:element>
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
