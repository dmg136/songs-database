<html>
<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="submit" value="Back" />
</form>

<?php

include 'database.php';

$con = connect();

$tune = "./tune/";
$chordPro = "./chordpro/";

if (!empty($_POST['searchTxt']))
{
	$searchTxtUpper = sanitize($_POST['searchTxt']);
	$noPunctuation = preg_replace("/[^A-Za-z0-9]/", " ", $searchTxtUpper);

	if ($_POST['filter'] == "contains")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"%$noPunctuation%\" OR UPPER(songChorus) LIKE \"%$noPunctuation%\" ORDER BY songTitle") or die (mysql_error());
	else if ($_POST['filter'] == "exact")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) = \"$searchTxtUpper\" OR UPPER(songChorus) = \"$searchTxtUpper\" ORDER BY songTitle") or die (mysql_error());
	else if ($_POST['filter'] == "begins")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$searchTxtUpper%\" OR UPPER(songChorus) LIKE \"$searchTxtUpper%\" ORDER BY songTitle") or die (mysql_error());

	//display columns
	echo "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"edit.php\">";
	echo "<table border=4 cellspacing=5 cellpadding=5>";
	echo "<tr>";
	echo "<td></td>";
	echo "<td><b> Song Title </b></td>";
	echo "<td><b> Song Chorus </b></td>";
	echo "<td><b> Tune </b></td>";
	echo "<td><b> ChordPro </b></td>";
	echo "<td><b> Author </b></td>";
	echo "<td><b> Strum </b></td>";
	echo "</tr>";
	
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
		echo "<td>" . $row['strum'] . "</td>";
		echo "</tr>";
	}

	echo "</table>";
	
	echo "<input type=\"submit\" name=\"edit\" value=\"Edit\" />";
	echo "</form>";
}
else if (!empty($_POST['searchLyrics']))
{
	//$searchLyricsUpper = sanitize($_POST['searchLyrics']);
	//$noPunctuation = preg_replace("/[^A-Za-z0-9]/", " ", $searchLyricsUpper);
	
	$keyWords = sanitize($_POST['searchLyrics']);
	$results = array();
	
	//sql query for all songs
	$sql = "SELECT * FROM song ORDER BY songTitle";
	
	$temp = mysql_query($sql, $con) or die (mysql_error());
	
	//iterate through row['chordPro']
	while ($row = mysql_fetch_array($temp))
	{
		if (!empty($row['chordPro']))
		{
			$line = $row['chordPro'];
			$dir = $chordPro . $line;
			//read .txt file into string
			$file = file_get_contents($dir) or die("Can't open $dir");
			//$fileNoChords = preg_replace("/\[[A-Za-z#]*[0-9]*\]/", "", $file);
			$fileNoChords = preg_replace("/\[(.*?)\]/", "", $file);
			
			$fileNoPunct = preg_replace("/[\",.!;:'-]/", "", $fileNoChords);
			$keyWordsNoPunct = preg_replace("/[\",.!;:'-]/", "", $keyWords);
			
			$fileNoDash = preg_replace("/—/", " ", $fileNoPunct);
			
			$fileNoBraces = preg_replace("/\{(.*?)\}/", "", $fileNoDash);
			$fileNoStanzaNum = preg_replace("/(\s)*[0-9](\s)+/", "", $fileNoBraces);
			$fileNoSpaces = preg_replace("/\s/", "", $fileNoStanzaNum);
			
			$keyWordsNoSpaces = preg_replace("/\s/", "", $keyWordsNoPunct);
		
			//do strpos to see if string contains keywords
			if (strpos(strtoupper($fileNoSpaces), strtoupper($keyWordsNoSpaces)) !== FALSE)
			{
				//add sid to results
				array_push($results, $row['sid']);
			}
		}
	}
	
	//display columns
	echo "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"edit.php\">";
	echo "<table border=4 cellspacing=5 cellpadding=5>";
	echo "<tr>";
	echo "<td></td>";
	echo "<td><b> Song Title </b></td>";
	echo "<td><b> Song Chorus </b></td>";
	echo "<td><b> Tune </b></td>";
	echo "<td><b> ChordPro </b></td>";
	echo "<td><b> Author </b></td>";
	echo "<td><b> Strum </b></td>";
	echo "</tr>";
	
	//displayResults
	for ($i = 0; $i < sizeof($results); $i++)
	{
		$sid = $results[$i];
		$tempSQL = "SELECT * from song WHERE sid = $sid";
		$tempRow = mysql_query($tempSQL, $con);
		$row = mysql_fetch_array($tempRow);
		
		echo "<tr>";
		echo "<td><input type=\"radio\" name=\"result\" value=\"" . $row['sid'] . "\" /></td>";
		echo "<td>" . $row['songTitle'] . "</td>";
		echo "<td>" . $row['songChorus'] . "</td>";
		echo "<td><a href=\"" . $tune . $row['tune'] . "\">" . $row['tune'] . "</a></td>";
		echo "<td><a href=\"" . $chordPro . $row['chordPro'] . "\">" . $row['chordPro'] . "</a></td>";
		echo "<td>" . $row['author'] . "</td>";
		echo "<td>" . $row['strum'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<input type=\"submit\" name=\"edit\" value=\"Edit\" />";
	echo "</form>";
}
else
{
	print "No search string specified";
}

close($con);
?>

<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="back" value="Back" />
</form>

</html>