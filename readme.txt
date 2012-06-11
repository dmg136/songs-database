TODO
- instead of hyperlink for midi, have inline play button?
	- make sure even supported on older browsers/computers
- better strum videos
- have search bar on top of results.php?
- have letter search on top of results.php?
- cache lyric search results (common words)
- fix insert.php to actually insert into database (untested)
	- for tune and chordpro, move file to server's ./tune/<name> or ./chordpro/<name> and when inserting into database, only store <name>
	http://www.w3schools.com/php/php_file_upload.asp
- edit a song's info (insert into database not done yet, update.php)
-------------------------------------------------------
- maybe alternative titles?
- have no punctuation/whitespace title?
- consolidate result.php, alphabetSearch.php and displayAll.php
- implement categories? (e.g. Loving the Lord, Praising, etc)
- typo correction? (if no results, then run typo corrector)
- have tune finder?
- GUI database
- GUI chordpro maker (easy to make chordpro generator, click chords to syllables)
- interactive songbook creator (pick chordpro songs, generate html and have pages where user can move songs around and format to their liking)

DOCUMENTATION
- iteratetitles.php goes through titles.txt, choruses.txt, strum.txt, tune directory, and chordpro directory and inserts entries into database
- songbookform.php inserts single entry into database
- insert.php inserts songbookform.htm POST data into database
- search.php searches database by song title
- result.php displays results of search.php query
- displayAll.php displays all songs in database
- database.php contains functions
- editform.php searches for a song to edit
- pick.php displays results of editform.php query
- edit.php allows user to edit the selected song's info
- update.php updates the song's info