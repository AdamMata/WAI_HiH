<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/">
		<creators>
			<xsl:element name="studios">
				<xsl:attribute name="count">
					<xsl:value-of select="count(games/game/contributors/author[@type='studio'])"/>
				</xsl:attribute>
				<xsl:apply-templates select="games/game/contributors/author[@type='studio']"/>
			</xsl:element>
 			
			<xsl:element name="indies">
				<xsl:attribute name="count">
					<xsl:value-of select="count(games/game/contributors/author[@type='indie'])"/>
				</xsl:attribute>
				<xsl:apply-templates select="games/game/contributors/author[@type='indie']"/>
			</xsl:element>
		</creators>
	</xsl:template>

	<xsl:template match="author">
		<creator>
			<xsl:attribute name="name">
				<xsl:value-of select="text()"/>
			</xsl:attribute>
			<xsl:variable name="current">
				<xsl:value-of select="text()"/>
			</xsl:variable>
			<xsl:apply-templates select="//game[contributors/author[text() = $current]]"/>
		</creator>
	</xsl:template>

	<xsl:template match="game">
		<xsl:variable name="title">
			<xsl:value-of select="@title"/>
		</xsl:variable>
		<xsl:variable name="stage">
			<xsl:value-of select="contributors/release/@stage"/>
		</xsl:variable>
		<xsl:element name="{translate($title, ' ', '-')}">
			<xsl:attribute name="{$stage}">
				<xsl:value-of select="contributors/release"/>
			</xsl:attribute>
			<xsl:copy-of select="requirements/engine"/>
			<genres>
				<xsl:apply-templates select="genres/genre"/>
			</genres>
		</xsl:element>
	</xsl:template>

	<xsl:template match="genre">
		<xsl:if test="@category">
			<xsl:copy>
				<xsl:attribute name="{@category}">
					<xsl:value-of select="."/>
				</xsl:attribute>
			</xsl:copy>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>