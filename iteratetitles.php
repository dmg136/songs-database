<?php
$txt = "titles.txt";
$chorus = "choruses.txt";
$strum = "strum.txt";
$tune = opendir('./tune');
$chordPro = opendir('./chordpro');

$lines = file($txt, FILE_IGNORE_NEW_LINES) or die("Can't open titles.txt");
//$chorusLines = file($chorus, FILE_IGNORE_NEW_LINES) or die("Can't open choruses.txt");
$chorusLines = fopen("$chorus", "r") or die ("Can't open choruses.txt");
$strumLines = fopen("$strum", "r") or die ("Can't open strum.txt");

$con = mysql_connect('127.0.0.1', 'root', '1234567890') or die (mysql_error());

mysql_select_db('songs', $con) or die (mysql_error());

$tempTune = null;
$tempChord = null;

//don't want . and .. as inputs
$tuneFile = readdir($tune);
$tuneFile = readdir($tune);
$chordProFile = readdir($chordPro);
$chordProFile = readdir($chordPro);

//delete all rows in table
$temp = "DELETE FROM song";
mysql_real_escape_string(mysql_query($temp, $con)) or die(mysql_error());

//reset auto increment to start from 1
$temp = "ALTER TABLE song AUTO_INCREMENT = 1";
mysql_real_escape_string(mysql_query($temp, $con)) or die (mysql_error());

//insert song into table
foreach ($lines as $line_num => $line) {
	
	echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	
	$chorusLine = null;
	$strumLine = null;
	$tempTune = null;
	$tempChord = null;
	
	if (!feof($chorusLines))
	{
		$chorusLine = fgets($chorusLines);

		if (strcmp(trim($chorusLine), "null") == 0)
			$chorusLine = null;
	}
	
	if (!feof($strumLines))
		$strumLine = fgets($strumLines);
	
	if (false !== ($tuneFile = readdir($tune)))
		$tempTune = $tuneFile;
		
	if (false !== ($chordProFile = readdir($chordPro)))
		$tempChord = $chordProFile;
	
	if ($chorusLine == null && $tempTune == null && $tempChord == null)
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",null,null,null, $strumLine)";
	}
	
	else if ($chorusLine == null && $tempTune == null)
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",null,null,\"$tempChord\", $strumLine)";
	}
	
	else if ($chorusLine == null && $tempChord == null)
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",null,\"$tempTune\",null, $strumLine)";
	}
	
	else if ($tempTune == null && $tempChord == null)
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",\"$chorusLine\",null,null, $strumLine)";
	}
	
	else if ($tempTune == null)
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",\"$chorusLine\",null,\"$tempChord\", $strumLine)";
	}
	
	else if ($tempChord == null)
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",\"$chorusLine\",\"$tempTune\",null, $strumLine)";
	}
	
	else if ($chorusLine == null)
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",null,\"$tempTune\",\"$tempChord\", $strumLine)";
	}
	
	else
	{
		$sql="INSERT INTO song (sid, songTitle, songChorus, tune, chordpro, strum) VALUES (null,\"$line\",\"$chorusLine\",\"$tempTune\",\"$tempChord\", $strumLine)";
	}

	mysql_real_escape_string(mysql_query($sql, $con) or die (mysql_error()));
}

fclose($chorusLines);
fclose($strumLines);
mysql_close($con);
closedir($tune);
closedir($chordPro);
?>