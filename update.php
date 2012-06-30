<html>

<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="back" value="Back" />
</form>

<?php
include 'database.php';

print "SID: " . $_POST['sid'] . "<br />";
print "Song Title: " . $_POST['songTitle'] . "<br />";
print "Song Chorus: " . $_POST['songChorus'] . "<br />";
print "Strum: " . $_POST['strum'] . "<br />";
print "Author: " . $_POST['author'] . "<br />";

if (!empty($_FILES['tune']['name']))
	print "Tune: " . $_FILES['tune']['name'] . "<br />";
else
	print "Tune not changed<br />";
	
if (!empty($_FILES['chordPro']['name']))
	print "ChordPro: " . $_FILES['chordPro']['name'] . "<br />";
else
	print "ChordPro not changed<br />";

$con = connect();	
	
$sql = "SELECT * from song WHERE sid=" . $_POST['sid'];
$result = mysql_query($sql, $con) or die ("Could not find song");

$row = mysql_fetch_array($result);

print "---------------------------<br />";

$songTitleChanged = false;
$chorusChanged = false;
$tuneChanged = false;
$chordProChanged = false;
$authorChanged = false;
$strumChanged = false;

if (!empty($_POST['songTitle']))
{
	if (strcmp($row['songTitle'], $_POST['songTitle']) != 0)
	{
		$songTitleChanged = true;
	}
}
if (!empty($_POST['songChorus']))
{
	if (strcmp($row['songChorus'], $_POST['songChorus']) != 0)
	{
		$chorusChanged = true;
	}
}
if (!empty($_FILES['tune']['name']))
{
	if (strcmp($row['tune'], $_FILES['tune']['name']) != 0)
	{
		$tuneChanged = true;
	}
}
if (!empty($_FILES['chordPro']['name']))
{
	if (strcmp($row['chordPro'], $_FILES['chordPro']['name']) != 0)
	{
		$chordProChanged = true;
	}
}
if (!empty($_POST['author']))
{
	if (strcmp($row['author'], $_POST['author']) != 0)
	{
		$authorChanged = true;
	}
}
if (!empty($_POST['strum']))
{
	if (strcmp($row['strum'], $_POST['strum']) != 0)
	{
		$strumChanged = true;
	}
}

if ($songTitleChanged || $chorusChanged || $tuneChanged || $chordProChanged || $authorChanged || $strumChanged)
{
	//test this later
	$updateSql = "UPDATE song SET songTitle=\"" . $_POST['songTitle'] . "\",
									songChorus=\"" . $_POST['songChorus'] . "\",
									tune=\"" . $_FILES['tune']['name'] . "\",
									chordPro=\"" . $_FILES['chordPro']['name'] . "\",
									author=\"" . $_POST['author'] . "\",
									strum=\"" . $_POST['strum'] . "\"
									WHERE sid=\"" . $_POST['sid'] . "\"";
	$updateQuery = mysql_query($updateSql, $con) or die ("Couldn't use query update");
} 

close($con);
?>

<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="back" value="Back" />
</form>
</html>