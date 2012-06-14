<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$tune = "./tune/";
$chordPro = "./chordpro/";

$con = connect();

if (!empty($_POST['searchTxt']))
{

	$searchTxtUpper = sanitize($_POST['searchTxt']);
	$noPunctuation = preg_replace("/[^A-Za-z0-9]/", " ", $searchTxtUpper);

	if ($_POST['filter'] == "contains")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"%$noPunctuation%\" OR UPPER(songChorus) LIKE \"%$noPunctuation%\"") or die (mysql_error());
	else if ($_POST['filter'] == "exact")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) = \"$searchTxtUpper\" OR UPPER(songChorus) = \"$searchTxtUpper\"") or die (mysql_error());
	else if ($_POST['filter'] == "begins")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$searchTxtUpper%\" OR UPPER(songChorus) LIKE \"$searchTxtUpper%\"") or die (mysql_error());
		
	displayResults($sql);
}
else if (!empty($_POST['searchLyrics']))
{
	$keyWords = sanitize($_POST['searchLyrics']);
	$results = array();
	
	//sql query for all songs
	$sql = "SELECT * FROM song";
	
	$temp = mysql_query($sql, $con) or die (mysql_error());
	
	//iterate through row['chordPro']
	while ($row = mysql_fetch_array($temp))
	{
		$line = $row['chordPro'];
		$dir = $chordPro . $line;
		//read .txt file into string
		$file = file_get_contents($dir, FILE_IGNORE_NEW_LINES) or die("Can't open $dir");
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
	
	//displayResults
	//displayColumns();
	for ($i = 0; $i < sizeof($results); $i++)
	{
		$sid = $results[$i];
		$tempSQL = "SELECT * from song WHERE sid = $sid";
		$tempRow = mysql_query($tempSQL, $con);
		$row = mysql_fetch_array($tempRow);
		
		$rowNoSpaces = preg_replace("/\s/", "", strtoupper($row['songTitle']));
		$rowNoPunctuation = preg_replace("/[\!\?;.,'-]/", "", $rowNoSpaces);
		echo "<tr>";
		echo "<td><br /><a href=\"./pages/" . $rowNoPunctuation . ".htm\">" . $row['songTitle'] . "</a><br /></td>";
		echo "</tr>";
	}
	echo "</table>";
}
else
{
	print "No search string specified";
}
close($con);
?>

<form action="search.php">
<input type="submit" value="Back" /><br />
</form>