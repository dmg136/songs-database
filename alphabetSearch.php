<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$con = connect();

$letter = sanitize($_SERVER['QUERY_STRING']);

if (strpos($letter, 'FIRSTLINE') !== false)
{
	$temp = preg_replace("/FIRSTLINE=/", "", $letter);
	
	if (strlen($temp) == 1)
	{
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$temp%\"") or die (mysql_error());
	
		displayResults($sql);
	}
}

if (strpos($letter, 'CHORUS') !== false)
{
	$temp = preg_replace("/CHORUS=/", "", $letter);
	
	if (strlen($temp) == 1)
	{
		$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) LIKE \"$temp%\"") or die (mysql_error());
	
		displayResults($sql);
	}
}
	
close($con);

?>

<form action="search.php">
<input type="submit" value="Back" /><br />
</form>