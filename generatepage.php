<?php

include 'database.php';
$con = connect();
$sql = "SELECT * from song";

$query = mysql_query($sql, $con) or die ("Couldn't query song table");

$alpha = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

while ($row = mysql_fetch_array($query))
{
	$rowNoSpaces = preg_replace("/\s/", "", strtoupper($row['songTitle']));
	$rowNoPunctuation = preg_replace("/[\!\?;.,'-]/", "", $rowNoSpaces);
	
	$dir = "./pages/" . $rowNoPunctuation . ".htm";
	$file = fopen($dir, 'w') or die("Can't create file");
	fwrite($file, "<html>\n");
	fwrite($file, "<head>\n");
	fwrite($file, "<title>" . $row['songTitle'] . "</title>");
	fwrite($file, "<link rel=\"stylesheet\" type=\"text/css\" href=\"./samplepage.css\" />");
	fwrite($file, "</head>");
	fwrite($file, "<body>");
	fwrite($file, "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"../result.php\">");
	fwrite($file, "Search: <input type=\"text\" name=\"searchLyrics\" size=61 maxlength=60 />");
	fwrite($file, "<input type=\"submit\" name=\"submit\" value=\"Submit\" /><br />");
	fwrite($file, "</form>");
	fwrite($file, "First Line: ");
	
	for ($a = 0; $a < 26; $a++)
	{
		$tempLine = "<a href=\"../alphabetSearch.php?firstline=" . $alpha[$a] . "\"> $alpha[$a] </a>&nbsp";
		fwrite($file, $tempLine);
	}
	
	fwrite($file, "<br />");
	fwrite($file, "Chorus: ");
	
	for ($a = 0; $a < 26; $a++)
	{
		$tempLine = "<a href=\"../alphabetSearch.php?chorus=" . $alpha[$a] . "\"> $alpha[$a] </a>&nbsp";
		fwrite($file, $tempLine);
	}
	
	fwrite($file, "<br />");
	fwrite($file, "<h2>" . $row['songTitle'] . "</h2>");
	
	$tuneScript = "<object height=\"15px\" width=\"200px\" data=\"../tune/" . $row['tune'] . "\" /><param name=\"autoplay\" value=\"false\"></object><br />";
	
	fwrite($file, $tuneScript);
	$tempLyric = displayLyrics($row['chordPro']);
	fwrite($file, $tempLyric);
	fwrite($file, "<br />");
	
	$chordPro = "ChordPro: <a href=\"../chordpro/" . $row['chordPro'] . "\">Link</a><br />";
	
	fwrite($file, $chordPro);
	fwrite($file, "Suggested Strum: " . $row['strum']);
	fwrite($file, "</body>");
	fwrite($file, "</html>");
	fclose($file);
}

echo "Success!";

close($con);
?>