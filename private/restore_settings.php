<?php
$file_path = __DIR__ . "/../sites/default/settings.php";
print __FILE__ . ": Attempting to operate on $file_path.\n";
rename($file_path ."-copy", $file_path);
$fp = fopen($file_path, "r+");
fwrite($fp, '// restored: ' . time() . "\n");
fclose($fp);
