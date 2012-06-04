<html>

<?php

include 'database.php';

if (!empty($_POST['result']))
{
	$con = connect();
	
	$sid = sanitize($_POST['result']);
	
	$sql = "SELECT * from song WHERE sid = $sid";
	
	$temp = mysql_query(sanitize($sql));
	
	$pick = mysql_fetch_array($temp);
	
	echo "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"update.php\">";
	echo "(max length) <br />";
	echo "Author (50): <input type=\"text\" name=\"author\" value=\"" . $pick['author'] . "\" size=51 maxlength=50 /><br />";
	echo "Song Title (60): <input type=\"text\" name=\"songTitle\" value=\"" . $pick['songTitle'] . "\" size=61 maxlength=60 /><br />";
	echo "Chorus (60): <input type=\"text\" name=\"songChorus\" value=\"" . $pick['songChorus'] . "\" size=61 maxlength=60 /><br />";
	echo "Upload Tune: <input type=\"file\" name=\"tune\" value=\"" . $pick['tune'] . "\" size=60 /><br />";
	echo "Upload ChordPro file: <input type=\"file\" name=\"chordPro\" value=\"" . $pick['chordPro'] . "\" size=60 /><br />";
	echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" />";
	echo "</form>";

	close($con);
}
else
{
	echo "No result";
}

?>

<form method="POST" enctype="multipart/form-data" action="editform.php">
<input type="submit" name="back" value="Back" />
</form>
</html>