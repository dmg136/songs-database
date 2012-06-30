<html>
<form method="POST" enctype="multipart/form-data" action="insert.php">
(# = max length) (bold = required)<br />
Author (50): <input type="text" name="author" size=51 maxlength=50 /><br />
<b>Song Title (60):</b> <input type="text" name="songTitle" size=61 maxlength=60 /><br />
Chorus (60): <input type="text" name="songChorus" size=61 maxlength=60 /><br />
Strum: <select name="strum">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		</select><br />
<label for="tune">Upload Tune:</label> <input type="file" name="tune" id="tune" size=60 /><br />
<label for="chordPro"><b>Upload ChordPro file:</b></label> <input type="file" name="chordPro" id="chordPro" size=60 /><br />
<input type="submit" name="submit" value="Submit" />
</form>

<?php
include 'database.php';
displayStrums();
?>
<a href="search.php">Search Songs</a>
<br />
<br />
<a href="http://tenbyten.com/software/songsgen/">Songsheet Generator</a>

</html>