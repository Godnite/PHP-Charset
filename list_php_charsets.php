<?php

/*************************************************************************/
/*                                                                       */
/* It generates the best "list of charsets supported by PHP" it can make */
/*                                                                       */
/*************************************************************************/

$LF = "\n";

$windows = strncasecmp(PHP_OS, 'WIN', 3) === 0;
$file_mode = $windows ? 'xb' : 'x';

$file = fopen(__DIR__ . '/charsets.csv', $file_mode);
fwrite($file, 'Generated list of charsets supported by PHP' . $LF);
fwrite($file, 'Name;Aliases' . $LF);

$charsets = \mb_list_encodings();

usort($charsets, 'strnatcasecmp');

foreach ($charsets as $charset) {	
	$aliases = mb_encoding_aliases($charset);
	array_unshift($aliases, $charset);
	$aliases = array_unique($aliases);
	$line = implode(';', $aliases) . $LF;
	fwrite($file, $line);
}

fclose($file);
