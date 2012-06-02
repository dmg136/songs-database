<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$con = connect();

if (!empty($_POST['searchTxt']))
{

	$searchTxtUpper = mysql_real_escape_string(strtoupper($_POST['searchTxt']));
	$noPunctuation = preg_replace("/[^A-Za-z0-9]/", " ", $searchTxtUpper);

	if ($_POST['searchType']=="songTitle")
	{
		if ($_POST['filter'] == "contains")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"%$noPunctuation%\"") or die (mysql_error());
		else if ($_POST['filter'] == "exact")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) = \"$searchTxtUpper\"") or die (mysql_error());
		else if ($_POST['filter'] == "begins")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$searchTxtUpper%\"") or die (mysql_error());
	}
	
	else if ($_POST['searchType']=="chorus")
	{
		if ($_POST['filter'] == "contains")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) LIKE \"%$noPunctuation%\"") or die (mysql_error());
		else if ($_POST['filter'] == "exact")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) = \"$searchTxtUpper\"") or die (mysql_error());
		else if ($_POST['filter'] == "begins")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) LIKE \"$searchTxtUpper%\"") or die (mysql_error());
	}
	
	$tune = "./tune/";
	$chordPro = "./chordpro/";
	
	//display columns
	echo "<table border=4 cellspacing=5 cellpadding=5>";
	echo "<tr>";
	echo "<td><b> Song Title </b></td> <td><b> Song Chorus </b></td> <td><b> Tune </b></td> <td><b> ChordPro </b></td>";
	echo "</tr>";
	
	//display results
	while ($row = mysql_fetch_array($sql))
	{
		echo "<tr>";
		echo "<td>" . $row['songTitle'] . "</td>";
		echo "<td>" . $row['songChorus'] . "</td>";
		echo "<td><a href=\"" . $tune . $row['tune'] . "\">" . $row['tune'] . "</a></td>";
		echo "<td><a href=\"" . $chordPro . $row['chordPro'] . "\">" . $row['chordPro'] . "</a></td>";
		echo "</tr>";
	}
	echo "</table>";
}
else
{
	print "No search string specified";
}
mysql_close($con);
?>

<form action="search.php">
<input type="submit" value="Back" /><br />
</form>