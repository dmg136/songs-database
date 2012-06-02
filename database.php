<?php

function connect($host = '127.0.0.1', $user='root', $pass='1234567890', $database = 'songs')
{
	$conn = mysql_connect($host, $user, $pass) or die (mysql_error());
	mysql_select_db($database, $conn) or die (mysql_error());
	return $conn;
}

function displayResults($sql)
{
	$tune = "./tune/";
	$chordPro = "./chordpro/";

	//display columns
	echo "<table border=4 cellspacing=5 cellpadding=5>";
	echo "<tr>";
	echo "<td><b> Song Title </b></td>";
	echo "<td><b> Song Chorus </b></td>";
	echo "<td><b> Tune </b></td>";
	echo "<td><b> ChordPro </b></td>";
	echo "<td><b> Author </b></td>";
	echo "</tr>";

	//display results
	while ($row = mysql_fetch_array($sql))
	{
		echo "<tr>";
		echo "<td>" . $row['songTitle'] . "</td>";
		echo "<td>" . $row['songChorus'] . "</td>";
		echo "<td><a href=\"" . $tune . $row['tune'] . "\">" . $row['tune'] . "</a></td>";
		echo "<td><a href=\"" . $chordPro . $row['chordPro'] . "\">" . $row['chordPro'] . "</a></td>";
		echo "<td>" . $row['author'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
}

function sanitize($str)
{
	$sanitizeStr = mysql_real_escape_string(strtoupper($str));
	return $sanitizeStr;
}

function close($con)
{
	mysql_close($con);
}

?>