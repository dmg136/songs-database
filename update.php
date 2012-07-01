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

if ($_POST['reloadTune'] == "delete")
	print "Tune deleted<br />";
else if (!empty($_FILES['tune']['name']))
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

if (!empty($_POST['songTitle']))
{
	if (strcmp($row['songTitle'], $_POST['songTitle']) != 0)
	{
		$updateSql = "UPDATE song SET songTitle=\"" . $_POST['songTitle'] . "\" WHERE sid=\"" . $_POST['sid'] . "\"";
		mysql_query($updateSql, $con) or die ("Couldn't use query update");
	}
	
}
if (!empty($_POST['songChorus']))
{
	if (strcmp($row['songChorus'], $_POST['songChorus']) != 0)
	{
		$updateSql = "UPDATE song SET songChorus=\"" . $_POST['songChorus'] . "\" WHERE sid=\"" . $_POST['sid'] . "\"";
		mysql_query($updateSql, $con) or die ("Couldn't use query update");
	}
}
else
{
	$updateSql = "UPDATE song SET songChorus=null WHERE sid=\"" . $_POST['sid'] . "\"";
	mysql_query($updateSql, $con) or die ("Couldn't use query update");
}

if ($_POST['reloadTune'] == "delete" && $row['tune'] != null)
{
	$tuneDir = "./tune/" . $row['tune'];
	unlink($tuneDir);
	
	$updateSql = "UPDATE song SET tune=null WHERE sid=\"" . $_POST['sid'] . "\"";
	mysql_query($updateSql, $con) or die ("Couldn't use query update");
}
else if (!empty($_FILES['tune']['name']) && $_POST['reloadTune'] == "yes")
{
	if (strcmp($row['tune'], $_FILES['tune']['name']) != 0)
	{
		$tuneDir = "./tune/" . $_FILES['tune']['name'];
		$tempTune = $_FILES['tune']['tmp_name'];
		move_uploaded_file($tempTune, $tuneDir);
		
		$updateSql = "UPDATE song SET tune=\"" . $_FILES['tune']['name'] . "\" WHERE sid=\"" . $_POST['sid'] . "\"";
		mysql_query($updateSql, $con) or die ("Couldn't use query update");
	}
}

if (!empty($_FILES['chordPro']['name']) && $_POST['reloadChordPro'] == "yes")
{
	if (strcmp($row['chordPro'], $_FILES['chordPro']['name']) != 0)
	{
		$chordProDir = "./chordpro/" . $_FILES['chordPro']['name'];
		$tempChordPro = $_FILES['chordPro']['tmp_name'];
		move_uploaded_file($tempChordPro, $chordProDir);
		
		if ($row['chordPro'] != null)
		{
			$chordProDir = "./chordpro/" . $row['chordPro'];
			unlink($chordProDir);
		}
	
		$updateSql = "UPDATE song SET chordPro=\"" . $_FILES['chordPro']['name'] . "\" WHERE sid=\"" . $_POST['sid'] . "\"";
		mysql_query($updateSql, $con) or die ("Couldn't use query update");
	}
}

if (!empty($_POST['author']))
{
	if (strcmp($row['author'], $_POST['author']) != 0)
	{
		$updateSql = "UPDATE song SET author=\"" . $_POST['author'] . "\" WHERE sid=\"" . $_POST['sid'] . "\"";
		mysql_query($updateSql, $con) or die ("Couldn't use query update");
	}
}
else
{
	$updateSql = "UPDATE song SET author=null WHERE sid=\"" . $_POST['sid'] . "\"";
	mysql_query($updateSql, $con) or die ("Couldn't use query update");
}

if (!empty($_POST['strum']))
{
	if (strcmp($row['strum'], $_POST['strum']) != 0)
	{
		$updateSql = "UPDATE song SET strum=\"" . $_POST['strum'] . "\" WHERE sid=\"" . $_POST['sid'] . "\"";
		mysql_query($updateSql, $con) or die ("Couldn't use query update");
	}
}

close($con);
?>

<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="back" value="Back" />
</form>
</html>