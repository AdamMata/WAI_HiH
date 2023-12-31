<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/">
		<html>
			<head>
				<link rel="stylesheet" href="styles.css"/>
			</head>	
			<body>
				<h1>Gry</h1>
				<xsl:apply-templates select="games"/>
				<div>
					<xsl:text>znaleziono </xsl:text>
					<xsl:value-of select="format-number(count(//*[@type]), '#0,00')"/>
					<xsl:text> użyć typów: </xsl:text>
					<xsl:apply-templates select="//@type"/>
					<br/>
					<xsl:text>w tym </xsl:text>
						<xsl:value-of select="format-number(count(//link), '0')"/>
					<xsl:text> z linków</xsl:text>
				</div>
			</body>
		</html>
	</xsl:template>

	<xsl:template match="games">
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
			<xsl:apply-templates select="game"/>
			<xsl:apply-templates select="game[last()]" mode="last"/>
		</table>
	</xsl:template>

	<xsl:template match="game">
		<tr>
			<td>
				<b><xsl:number value="position()" format="a"/></b>
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
				<xsl:apply-templates select="contributors/publisher"/>
			</td>
			<td>
				<xsl:apply-templates select="contributors/release"/>
			</td>
			<td>
				<xsl:apply-templates select="requirements/platforms"/>
			</td>
			<td>
				<xsl:apply-templates select="requirements/engine"/>
			</td>
			<td>
				<ul>
					<xsl:apply-templates select="genres/genre"/>
				</ul>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="game" mode="last">
		<xsl:text>Tabelę </xsl:text>
		<xsl:variable name="games" select="../game"/>
		<xsl:variable name="count" select="count($games)"/>
		<xsl:value-of select="$count"/>
		<xsl:choose>
			<xsl:when test="$count = 1">
				<xsl:text> gry</xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text> gier</xsl:text>
			</xsl:otherwise>
		</xsl:choose>
		<xsl:text> zakończono na grze </xsl:text>
		<xsl:value-of select="@title"/>
	</xsl:template>

	<xsl:template match="@type">
		<xsl:element name="span">
			<xsl:attribute name="class">
				type
			</xsl:attribute>
			<xsl:value-of select="."/>
		</xsl:element>
		<xsl:text> </xsl:text>
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

	<xsl:template match="publisher">
		<xsl:element name="span">
			<xsl:attribute name="class">
				type
			</xsl:attribute>
			<xsl:text>company</xsl:text>
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

	<xsl:template match="platforms">
		<xsl:for-each select="platform">
			<xsl:sort select="@system" order="ascending"/>
			<xsl:number value="position()"/>
			
			<xsl:value-of select="@system"/>
			<xsl:text> </xsl:text>
			<xsl:value-of select="."/>
			<xsl:element name="br"/>
			
		</xsl:for-each>
	</xsl:template>

	<xsl:template match="engine">
		<xsl:choose>
			<xsl:when test="@system='Unity'">
				<xsl:element name="img">
					<xsl:attribute name="src">
						images/Unity-logo.png
					</xsl:attribute>
					<xsl:attribute name="style">
						width: 70px;
					</xsl:attribute>
				</xsl:element>
			</xsl:when>
			<xsl:when test="@system='Unreal Engine'">
				<xsl:element name="img">
					<xsl:attribute name="src">
						images/Unreal_Engine-logo.png
					</xsl:attribute>
					<xsl:attribute name="style">
						width: 70px;
					</xsl:attribute>
				</xsl:element>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="@system"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="genre">
		<xsl:element name="li">
			<xsl:attribute name="class">
				genre
			</xsl:attribute>
			<xsl:if test="@category != ''">
				<xsl:element name="span">
					<xsl:attribute name="class">
						type
					</xsl:attribute>
					<xsl:value-of select="@category"/>
				</xsl:element>
				<xsl:text> </xsl:text>
			</xsl:if>
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
