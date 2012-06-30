<html>

<?php

include 'database.php';

if (!empty($_POST['songTitle']))
{
	$con = connect();
	
	$songTitle = $_POST['songTitle'];
	$songChorus = null;
	$strum = $_POST['strum'];
	$tune = null;
	$chordPro = null;
	$author = null;
	$temp1 = null;
	$temp2 = null;
	
	if (!empty($_POST['author']))
		$author = $_POST['author'];
	
	if (!empty($_POST['songChorus']))
		$songChorus = $_POST['songChorus'];
	
	if (!empty($_FILES["tune"]["name"]))
	{
		if ($_FILES["tune"]["type"] == "audio/mid")
		{
			$tune = $_FILES["tune"]["name"];
			$temp1 = $_FILES["tune"]["tmp_name"];
		}
	}
		
	if (!empty($_FILES["chordPro"]["name"]))
	{
		if ($_FILES["chordPro"]["type"] == "text/plain")
		{
			$chordPro = $_FILES["chordPro"]["name"];
			$temp2 = $_FILES["chordPro"]["tmp_name"];
		}
	}
	
	insert($con, $songTitle, $songChorus, $tune, $temp1, $chordPro, $temp2, $author, $strum);
	print "You have submitted $_POST['songTitle']<br />";
}
else
{
	echo "Must input song title<br />";
}
?>

<form action="songbookform.php">
<input type="submit" value="Back" /><br />
</form>
</html>