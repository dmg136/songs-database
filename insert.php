<html>

<?php

$con = mysql_connect('127.0.0.1', 'root', '1234567890') or die (mysql_error());
mysql_select_db('songs', $con) or die (mysql_error());

print "You have submitted: <br />";

if (!empty($_POST['author']))
{
	$author = $_POST['author'];
	print "Author: $author <br />";
}
else
	print "No author <br />";
	
if (!empty($_POST['songTitle']))
{
	$songTitle = $_POST['songTitle'];
	
	$sql=mysql_query("INSERT INTO song (sid, songTitle, tune, chordPro) VALUES (null, $songTitle, null, null") or die (mysql_error());
	
	print "Song Title: $songTitle <br />";
}
else
	print "No song title <br />";
	
if (!empty($_POST['songChorus']))
{
	$chorus = $_POST['songChorus'];
	print "Chorus: $chorus <br />";
}
else
	print "No chorus <br />";
	
if (!empty($_FILES['chordPro']['name']))
{
	$chordPro = $_FILES['chordPro']['name'];
	print "ChordPro file: $chordPro <br />";
}
else
	print "No ChordPro file <br />";
	
print "<br /> Press Back to submit another song <br />";


?>

<form action="songbookform.php">
<input type="submit" value="Back" /><br />
</form>

<?php
if (!empty($_POST['songTitle']))
{
	$con = mysql_connect('127.0.0.1', 'root', '1234567890') or die (mysql_error());
	mysql_select_db('songs', $con) or die (mysql_error());

	$songTitle = mysql_real_escape_string($_POST['songTitle']);
	
	$sql="INSERT INTO song (sid, songTitle, tune, chordPro) VALUES (null,$songTitle,null,null')";

	if (!mysql_query($sql, $con))
	{
		die (mysql_error());
	}
	else
	{
		mysql_close($con);
	}
}
else
{
	print "<br />did not submit song<br />";
}

?>

</html>