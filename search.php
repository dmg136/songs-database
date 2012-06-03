<html>
<b>Search songs</b><br />
<form method="POST" enctype="multipart/form-data" action="result.php">
<select name="searchType">
	<option value="songTitle">Song Title:</option>
	<option value="chorus">Chorus:</option>
</select>
<input type="text" name="searchTxt" size=61 maxlength=60 />
<select name="filter">
	<option value="contains">CONTAINS</option>
	<option value="exact">EXACT</option>
	<option value="begins">BEGINS</option>
</select>
<br />
<input type="submit" name="submit" value="Submit" />
</form>

<form method="POST" enctype="multipart/form-data" action="displayAll.php">
<b>Display All Songs</b>
<br />
<input type="submit" name="displayAll" value="Display All" />
</form>

<?php
$alpha = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

echo "<b>First Line Letter Search</b><br />";
for ($a = 0; $a < 26; $a++)
	echo "<a href=\"alphabetSearch.php?firstline=$alpha[$a]\"> $alpha[$a] </a>&nbsp";

echo "<br /><br /> ";

echo "<b>Chorus Letter Search</b><br />";
for ($a = 0; $a < 26; $a++)
	echo "<a href=\"alphabetSearch.php?chorus=$alpha[$a]\"> $alpha[$a] </a>&nbsp";

?>

<br />
<br />
<a href="http://tenbyten.com/software/songsgen/">Songsheet Generator</a>
</html>