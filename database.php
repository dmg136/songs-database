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
	//displayColumns();

	//display results
	while ($row = mysql_fetch_array($sql))
	{
		$rowNoSpaces = preg_replace("/\s/", "", strtoupper($row['songTitle']));
		$rowNoPunctuation = preg_replace("/[\!\?;.,'-]/", "", $rowNoSpaces);
		echo "<tr>";
		echo "<td><br /><a href=\"./pages/" . $rowNoPunctuation . ".htm\">" . $row['songTitle'] . "</a><br /></td>";
		echo "</tr>";
	}
	echo "</table>";
}

function displayLyrics($lyrics)
{
	$chordPro = "./chordpro/";
	$dir = $chordPro . $lyrics;
	$file = file_get_contents($dir, FILE_IGNORE_NEW_LINES) or die("Can't open $lyrics");
	$fileNoChords = preg_replace("/\[(.*?)\]/", "", $file);
	$fileNoBraces = preg_replace("/\{(.*?)\}/", "", $fileNoChords);
	
	$tempLyrics = "<td><textarea readonly=\"true\" name=\"lyrics\" cols=\"45\" rows=\"4\">" . ltrim($fileNoBraces) . "</textarea></td>";
	
	return $tempLyrics;
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

function backupDatabase()
{
	$con = connect();
	$sql = "SELECT * from song";
	$query = mysql_query($sql, $con) or die ("Can't query table song");
	$file = fopen("backup.database", 'w') or die ("Can't open backup.database");
	
	while ($row = mysql_fetch_array($query))
	{
		fwrite($file, "%\n");
		fwrite($file, $row['songTitle'] . "\n");
		
		if (empty($row['songChorus']))
			fwrite($file, "null\n");
		else
			fwrite($file, $row['songChorus']);
		
		if (empty($row['tune']))
			fwrite($file, "null\n");
		else
			fwrite($file, $row['tune'] . "\n");
			
		if (empty($row['chordPro']))
			fwrite($file, "null\n");
		else
			fwrite($file, $row['chordPro'] . "\n");
			
		if (empty($row['author']))
			fwrite($file, "null\n");
		else
			fwrite($file, $row['author'] . "\n");
			
		if (empty($row['strum']))
			fwrite($file, "null\n");
		else
			fwrite($file, $row['strum'] . "\n");
	}
	
	fclose($file);
	
	close($con);
}

function importDatabase()
{
	$con = connect();
	$columns = 6;
	//columns besides primary key sid
	$songTitle = null;
	$songChorus = null;
	$tune = null;
	$chordPro = null;
	$author = null;
	$strum = null;
	$tempCol = 0;
	$file = file("database.backup");
	
	foreach ($file as $line_num => $line)
	{
		$tempCol++;
		if ($line != "%")
		{
			if ($tempCol > 6)
			{
				$tempCol = 0;
				$insert = "INSERT INTO song VALUES(null, $songTitle, $songChorus, $tune, $chordPro, $author, $strum)";
				mysql_query($insert, $con) or die ("Failed to insert");
			}
			else
			{
				if ($tempCol == 1)
					$songTitle = $line;
				else if ($tempCol == 2)
					$songChorus = $line;
				else if ($tempCol == 3)
					$tune = $line;
				else if ($tempCol == 4)
					$chordPro = $line;
				else if ($tempCol == 5)
					$author = $line;
				else if ($tempCol == 6)
					$strum = $line;
			}
		}
		else
			$tempCol = 0;
	}
	
	close($con);
}

?>