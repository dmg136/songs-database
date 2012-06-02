<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$con = connect();

if (!empty($_POST['searchTxt']))
{

	$searchTxtUpper = sanitize($_POST['searchTxt']);
	$noPunctuation = preg_replace("/[^A-Za-z0-9]/", " ", $searchTxtUpper);

	if ($_POST['searchType']=="songTitle")
	{
		if ($_POST['filter'] == "contains")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"%$noPunctuation%\"") or die (mysql_error());
		else if ($_POST['filter'] == "exact")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) = \"$searchTxtUpper\"") or die (mysql_error());
		else if ($_POST['filter'] == "begins")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$searchTxtUpper%\"") or die (mysql_error());
			
		displayResults($sql);
	}
	
	else if ($_POST['searchType']=="chorus")
	{
		if ($_POST['filter'] == "contains")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) LIKE \"%$noPunctuation%\"") or die (mysql_error());
		else if ($_POST['filter'] == "exact")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) = \"$searchTxtUpper\"") or die (mysql_error());
		else if ($_POST['filter'] == "begins")
			$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) LIKE \"$searchTxtUpper%\"") or die (mysql_error());
			
		displayResults($sql);
	}
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