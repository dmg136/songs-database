<?php

function connect($host = '127.0.0.1', $user='root', $pass='1234567890', $database = 'songs')
{
	$conn = mysql_connect($host, $user, $pass) or die (mysql_error());
	mysql_select_db($database, $conn) or die (mysql_error());
	return $conn;
}

function insert($connection, $songTitle, $songChorus, $tune, $chordPro, $author, $strum)
{

	if ($_FILES["tune"]["type"] !== "audio/midi")
		$tune = null;
		
	if ($_FILES["chordPro"]["type"] !== "text/plain")
		$chordPro = null;

	if (file_exists("./tune/" . $_FILES["tune"]["name"]))
	{
	}
	else
	{
		//strip directory from name --- to be written
		$noDirName = null;
		move_uploaded_file($_FILES["tune"]["tmp_name"], "./tune/" . $_FILES["tune"]["name"]);
	}
	
	if (file_exists("./chordpro/" . $_FILES["chordPro"]["name"]))
	{
	}
	else
	{
		//strip directory from name --- to be written
		$noDirName = null;
		move_uploaded_file($_FILES["chordPro"]["tmp_name"], "./chordpro/" . $_FILES["chordPro"]["name"]);
	}
	$sql = sanitize("INSERT INTO song VALUES(null, $songTitle, $songChorus, $tune, $chordPro, $author)");
	mysql_query($sql, $connection) or die (mysql_error());
}

function displayStrums()
{
	echo "<p>";
	echo "<b>Suggested strums:</b><br />";
	echo "<a href=\"1standard_strum.avi\">1 - Standard Strum</a><br />";
	echo "<a href=\"2gallop_strum.avi\">2 - Gallop Strum</a><br />";
	echo "<a href=\"3skip_strum.avi\">3 - Skip Strum</a><br />";
	echo "4 - Follow the Lyrics (Change chords based on rhythm)<br />";
	echo "</p>";
}

function displayColumns()
{
	displayStrums();

	//display columns
	echo "<table border=4 cellspacing=5 cellpadding=5>";
	echo "<tr>";
	echo "<td><b> Song Title </b></td>";
	echo "<td><b> Song Chorus </b></td>";
	echo "<td><b> Tune </b></td>";
	echo "<td><b> ChordPro </b></td>";
	echo "<td><b> Author </b></td>";
	echo "<td><b> Suggested Strum </b></td>";
	echo "</tr>";
}

function displayResults($sql)
{
	$tune = "./tune/";
	$chordPro = "./chordpro/";

	//display columns
	displayColumns();

	//display results
	while ($row = mysql_fetch_array($sql))
	{
		echo "<tr>";
		echo "<td>" . $row['songTitle'] . "</td>";
		echo "<td>" . $row['songChorus'] . "</td>";
		echo "<td><a href=\"" . $tune . $row['tune'] . "\">" . $row['tune'] . "</a></td>";
		//echo "<td><object height=\"50px\" width=\"150px\" data=\"./tune/" . $row['tune'] . "\" /><param name=\"autostart\" value=\"false\"></td>";
		echo "<td><a href=\"" . $chordPro . $row['chordPro'] . "\">" . $row['chordPro'] . "</a></td>";
		echo "<td>" . $row['author'] . "</td>";
		echo "<td>" . $row['strum'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
}

function pickResult($sql)
{
	$tune = "./tune/";
	$chordPro = "./chordpro/";

	//display columns
	echo "<form enctype=\"multipart/form-data\" action=\"edit.php\">";
	displayColumns();
	
	//display results
	while ($row = mysql_fetch_array($sql))
	{
		echo "<tr>";
		echo "<td>";
		echo "<input type=\"radio\" name=\"result\" value=\"" . $row['sid'] . "\" /><br />";
		echo "</td>";
		echo "<td>" . $row['songTitle'] . "</td>";
		echo "<td>" . $row['songChorus'] . "</td>";
		echo "<td><a href=\"" . $tune . $row['tune'] . "\">" . $row['tune'] . "</a></td>";
		echo "<td><a href=\"" . $chordPro . $row['chordPro'] . "\">" . $row['chordPro'] . "</a></td>";
		echo "<td>" . $row['author'] . "</td>";
		echo "</tr>";
	}

	echo "</table>";
	echo "</form>";
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