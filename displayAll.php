<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$con = connect();

$sql=mysql_query("SELECT * FROM song ORDER BY songTitle") or die (mysql_error());

displayResults($sql);

close($con);
?>

<form action="search.php">
<input type="submit" value="Back" /><br />
</form>