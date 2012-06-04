<html>
<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="submit" value="Back" />
</form>

<?php

include 'database.php';

if (!empty($_POST['searchTxt']))
{
	$con = connect();

	$searchTxtUpper = sanitize($_POST['searchTxt']);
	$noPunctuation = preg_replace("/[^A-Za-z0-9]/", " ", $searchTxtUpper);

	if ($_POST['filter'] == "contains")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"%$noPunctuation%\" OR UPPER(songChorus) LIKE \"%$noPunctuation%\"") or die (mysql_error());
	else if ($_POST['filter'] == "exact")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) = \"$searchTxtUpper\" OR UPPER(songChorus) = \"$searchTxtUpper\"") or die (mysql_error());
	else if ($_POST['filter'] == "begins")
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$searchTxtUpper%\" OR UPPER(songChorus) LIKE \"$searchTxtUpper%\"") or die (mysql_error());
		
	$tune = "./tune/";
	$chordPro = "./chordpro/";

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
		echo "</tr>";
	}

	echo "</table>";
	
	echo "<input type=\"submit\" name=\"edit\" value=\"Edit\" />";
	echo "</form>";
	
	close($con);
}
else
{
	print "No search string specified";
}
?>

<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="back" value="Back" />
</form>

</html>