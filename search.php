<html>
<b>Search songs</b><br />
<form method="POST" enctype="multipart/form-data" action="result.php">
Song Title or Chorus: <input type="text" name="searchTxt" size=61 maxlength=60 />
<select name="filter">
	<option value="contains">CONTAINS</option>
	<option value="exact">EXACT</option>
	<option value="begins">BEGINS</option>
</select>
<br />
OR
<br />
Lyric Search (may take a while): <input type="text" name="searchLyrics" size=61 maxlength=60 />
<br />
<input type="submit" name="submit" value="Submit" />
</form>
<form method="POST" enctype="multipart/form-data" action="displayAll.php">
<b>Display All Songs</b>
<br />
<input type="submit" name="displayAll" value="Display All" />
</form>

<?php
include 'database.php';

$alpha = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

echo "<b>First Line Letter Search</b><br />";
for ($a = 0; $a < 26; $a++)
	echo "<a href=\"alphabetSearch.php?firstline=$alpha[$a]\"> $alpha[$a] </a>&nbsp";

echo "<br /><br /> ";

echo "<b>Chorus Letter Search</b><br />";
for ($a = 0; $a < 26; $a++)
	echo "<a href=\"alphabetSearch.php?chorus=$alpha[$a]\"> $alpha[$a] </a>&nbsp";

displayStrums();
?>

<form method="POST" enctype="multipart/form-data" action="displayStrum.php">
Songs with Strum:
<select name="strumNum">
	<option value=1>1</option>
	<option value=2>2</option>
	<option value=3>3</option>
	<option value=4>4</option>
</select>
<input type="submit" name="submitStrum" value="Submit" />
</form>

<b>Links</b><br />
<a href="./html/songs.htm">Songs in HTML format</a>
<br />
<a href="http://tenbyten.com/software/songsgen/">Songsheet Generator</a>
</html>