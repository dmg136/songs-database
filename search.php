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

<b>Letter Search</b><br />
<a href="alphabetSearch.php?A">A</a>
<a href="alphabetSearch.php?B">B</a>
<a href="alphabetSearch.php?C">C</a>
<a href="alphabetSearch.php?D">D</a>
<a href="alphabetSearch.php?E">E</a>
<a href="alphabetSearch.php?F">F</a>
<a href="alphabetSearch.php?G">G</a>
<a href="alphabetSearch.php?H">H</a>
<a href="alphabetSearch.php?I">I</a>
<a href="alphabetSearch.php?J">J</a>
<a href="alphabetSearch.php?K">K</a>
<a href="alphabetSearch.php?L">L</a>
<a href="alphabetSearch.php?M">M</a>
<a href="alphabetSearch.php?N">N</a>
<a href="alphabetSearch.php?O">O</a>
<a href="alphabetSearch.php?P">P</a>
<a href="alphabetSearch.php?Q">Q</a>
<a href="alphabetSearch.php?R">R</a>
<a href="alphabetSearch.php?S">S</a>
<a href="alphabetSearch.php?T">T</a>
<a href="alphabetSearch.php?U">U</a>
<a href="alphabetSearch.php?V">V</a>
<a href="alphabetSearch.php?W">W</a>
<a href="alphabetSearch.php?X">X</a>
<a href="alphabetSearch.php?Y">Y</a>
<a href="alphabetSearch.php?Z">Z</a>
<br />
<br />
<a href="http://tenbyten.com/software/songsgen/">Songsheet Generator</a>
</html>