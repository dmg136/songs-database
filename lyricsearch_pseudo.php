<?php

include 'database.php';

$tune = "./tune/";
$chordPro = "./chordpro/";
//$keyWords = sanitize($_POST['searchLyrics']);
$keyWords = "mystery";
$results = array();

$con = connect();

//sql query for all songs
$sql = "SELECT * FROM song";

$temp = mysql_query($sql, $con) or die (mysql_error());

//iterate through row['chordPro']
while ($row = mysql_fetch_array($temp))
{
	$line = $row['chordPro'];
	$dir = $chordPro . $line;
	//read .txt file into string
	$file = file_get_contents($dir, FILE_IGNORE_NEW_LINES) or die("Can't open $chordPro$line");
	
	//do strpos to see if string contains keywords
	if (strpos($file, $keyWords) !== FALSE)
	{
		//add sid to results
		array_push($results, $row['sid']);
	}
}

//displayResults
displayColumns();
for ($i = 0; $i < sizeof($results); $i++)
{
	$sid = $results[$i];
	$tempSQL = "SELECT * from song WHERE sid = $sid";
	$tempRow = mysql_query($tempSQL, $con);
	$row = mysql_fetch_array($tempRow);
	
	echo "<tr>";
	echo "<td>" . $row['songTitle'] . "</td>";
	echo "<td>" . $row['songChorus'] . "</td>";
	echo "<td><a href=\"" . $tune . $row['tune'] . "\">" . $row['tune'] . "</a></td>";
	echo "<td><a href=\"" . $chordPro . $row['chordPro'] . "\">" . $row['chordPro'] . "</a></td>";
	echo "<td>" . $row['author'] . "</td>";
	echo "</tr>";
}
echo "</table>";
close($con);
?>