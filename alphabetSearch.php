<form action="search.php">
<input type="submit" value="Back" /><br />
</form>

<?php

$con = mysql_connect('127.0.0.1', 'root', '1234567890') or die (mysql_error());
mysql_select_db('songs', $con) or die (mysql_error());

$letter = mysql_real_escape_string(strtoupper($_SERVER['QUERY_STRING']));

$sql=mysql_query("SELECT * FROM song WHERE UPPER(songTitle) LIKE \"$letter%\"") or die (mysql_error());

$tune = "./tune/";
$chordPro = "./chordpro/";

//display columns
echo "<table border=4 cellspacing=5 cellpadding=5>";
echo "<tr>";
echo "<td><b> Song Title </b></td> <td><b> Tune </b></td> <td><b> ChordPro </b></td>";
echo "</tr>";

//display results
while ($row = mysql_fetch_array($sql))
{
	echo "<tr>";
	echo "<td>" . $row['songTitle'] . "</td>";
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