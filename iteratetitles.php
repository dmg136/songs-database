<?php
$txt = "titles.txt";
$tune = opendir('./tune');
$chordPro = opendir('./chordpro');

$lines = file($txt, FILE_IGNORE_NEW_LINES) or die("Can't open file");

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
mysql_query($temp, $con) or die(mysql_error());

//reset auto increment to start from 1
$temp = "ALTER TABLE song AUTO_INCREMENT = 1";
mysql_query($temp, $con) or die (mysql_error());

//insert song into table
foreach ($lines as $line_num => $line) {
	echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	
	$tempTune = null;
	$tempChord = null;
	
	if (false !== ($tuneFile = readdir($tune)))
		$tempTune = $tuneFile;
		
	if (false !== ($chordProFile = readdir($chordPro)))
		$tempChord = $chordProFile;
	
	$sql="INSERT INTO song (sid, songTitle, tune, chordpro) VALUES (null,\"$line\",\"$tempTune\",\"$tempChord\")";

	mysql_query(mysql_real_escape_string($sql), $con) or die (mysql_error());
}


mysql_close($con);
closedir($tune);
closedir($chordPro);
?>