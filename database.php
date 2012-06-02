<?php

function connect($host = '127.0.0.1', $user='root', $pass='1234567890', $database = 'songs')
{
	$conn = mysql_connect($host, $user, $pass);
	mysql_select_db($database);
	return $conn;
}

function displayResults()
{
}

?>