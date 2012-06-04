<html>

<?php

include 'database.php';

print "You have submitted: <br />";

if (!empty($_POST['songTitle']))
{
	$con = connect();
	
	$songTitle = sanitize($_POST['songTitle']);
	$songChorus = null;
	$tune = null;
	$chordPro = null;
	$author = null;
	
	if (!empty($_POST['songChorus']))
		$songChorus = sanitize($_POST['songChorus']);
	
	if (!empty($_POST['tune']))
		$tune = sanitize($_POST['tune']);
		
	if (!empty($_POST['chordPro']))
		$chordPro = sanitize($_POST['chordPro']);
	
	if (!empty($_POST['author']))
		$author = sanitize($_POST['author']);
	
	insert($con, $songTitle, $songChorus, $tune, $chordPro, $author);
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