<html>
<form method="POST" action="search.php">
<input type="submit" value="Back" />
</form>

<?php
include 'database.php';

$con = connect();
$strum = sanitize($_POST['strumNum']);
$sql = "SELECT * from song WHERE strum = $strum";

$results = mysql_query($sql, $con) or die ("No results"); 

displayResults($results);

close($con);

?>

<form method="POST" action="search.php">
<input type="submit" value="Back" />
</form>

</html>