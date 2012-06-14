<?php

include 'database.php';
$con = connect();
$sql = "SELECT * from song";

$query = mysql_query($sql, $con) or die ("Couldn't query song table");

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
	fwrite($file, "Search: <input type=\"text\" name=\"search\" /><br />");
	fwrite($file, "First Line or Chorus Links:<br />");
	fwrite($file, "</a>");
	fwrite($file, "<h2>" . $row['songTitle'] . "</h2>");
	
	$tuneScript = "<object height=\"15px\" width=\"200px\" data=\"../tune/" . $row['tune'] . "\" /><param name=\"autoplay\" value=\"false\"></object><br />";
	
	fwrite($file, $tuneScript);
	$tempLyric = displayLyrics($row['chordPro']);
	fwrite($file, $tempLyric);
	fwrite($file, "<br />");
	fwrite($file, "ChordPro: <a href=\"\">Link</a><br />");
	fwrite($file, "Suggested Strum: " . $row['strum']);
	fwrite($file, "</body>");
	fwrite($file, "</html>");
	fclose($file);
}

close($con);
?>