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
	
	$strum = $pick['strum'];
	
	echo "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"update.php\">";
	echo "(max length) <br />";
	echo "<input type=\"hidden\" name=\"sid\" id=\"sid\" value=\"" . $pick['sid'] . "\" />";
	echo "Author (50): <input type=\"text\" name=\"author\" value=\"" . $pick['author'] . "\" size=51 maxlength=50 /><br />";
	echo "Song Title (60): <input type=\"text\" name=\"songTitle\" value=\"" . $pick['songTitle'] . "\" size=61 maxlength=60 /><br />";
	echo "Chorus (60): <input type=\"text\" name=\"songChorus\" value=\"" . $pick['songChorus'] . "\" size=61 maxlength=60 /><br />";
	echo "Strum: <select name=\"strum\">";
	
	if ($strum == "1")
		echo "	<option value=\"1\" selected=\"selected\">1</option>";
	else
		echo "	<option value=\"1\">1</option>";
		
	if ($strum == "2")
		echo "  <option value=\"2\" selected=\"selected\">2</option>";
	else
		echo "  <option value=\"2\">2</option>";
		
	if ($strum == "3")
		echo "  <option value=\"3\" selected=\"selected\">3</option>";
	else
		echo "  <option value=\"3\">3</option>";
		
	if ($strum == "4")
		echo "  <option value=\"4\" selected=\"selected\">4</option>";
	else
		echo "  <option value=\"4\">4</option>";
	
	echo"</select><br />";
	echo "Re-upload Tune? <select name=\"reloadTune\">";
	echo "  <option value=\"no\">no</option>";
	echo "  <option value=\"yes\">yes</option>";
	echo "  <option value=\"delete\">delete</option>";
	echo "</select>&nbsp";
	echo "Current Tune: <textarea readonly=\"true\" name=\"tuneTxt\" cols=\"60\" rows=\"1\">" . $pick['tune'] . "</textarea><br />";
	echo "Upload Tune: <input type=\"file\" name=\"tune\" size=60 /><br />";
	echo "<br />";
	
	echo "Re-upload ChordPro? <select name=\"reloadChordPro\">";
	echo "  <option value=\"no\">no</option>";
	echo "  <option value=\"yes\">yes</option>";
	echo "</select>&nbsp";
	echo "Current ChordPro: <textarea readonly=\"true\" name=\"chordProTxt\" cols=\"60\" rows=\"1\">" . $pick['chordPro'] . "</textarea><br />";
	echo "Upload ChordPro file: <input type=\"file\" name=\"chordPro\" size=60 /><br />";
	
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