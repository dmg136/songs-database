<html>

<b>Edit song</b><br />
<form method="POST" enctype="multipart/form-data" action="pick.php">
Song Title or Chorus: <input type="text" name="searchTxt" size=61 maxlength=60 />
<select name="filter">
	<option value="contains">CONTAINS</option>
	<option value="exact">EXACT</option>
	<option value="begins">BEGINS</option>
</select>
<br />
OR
<br />
Lyric Search: <input type="text" name="searchLyrics" size=61 maxlength=60 />
<br />
<input type="submit" name="submit" value="Submit" />
</form>

</html>