<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

include 'database.php';

$con = connect();

$sql=mysql_query("SELECT * FROM song") or die (mysql_error());

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

mysql_close($con);
?>

<form action="search.php">
<input type="submit" value="Back" /><br />
</form>