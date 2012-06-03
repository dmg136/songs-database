<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$con = connect();

$letter = sanitize($_SERVER['QUERY_STRING']);

//untested
if (strpos($letter, 'firstline') !== false)
{
	$temp = preg_replace("/firstline=/", "", $letter);
	$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$temp%\"") or die (mysql_error());
}

if (strpos($letter, 'chorus') !== false)
{
	$temp = preg_replace("/chorus=/", "", $letter);
	$sql=mysql_query("SELECT * FROM song WHERE UPPER(songChorus) LIKE \"$temp%\"") or die (mysql_error());
}

displayResults($sql);
	
close($con);

?>

<form action="search.php">
<input type="submit" value="Back" /><br />
</form>