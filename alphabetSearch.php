<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$con = connect();

$letter = sanitize($_SERVER['QUERY_STRING']);

$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$letter%\"") or die (mysql_error());

displayResults($sql);

close($con);

?>

<form action="search.php">
<input type="submit" value="Back" /><br />
</form>