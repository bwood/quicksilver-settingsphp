<?php
// so I know this worked testing
$file_path = __DIR__ . "/../sites/default/settings.php";
print __FILE__ . ": Attempting to operate on $file_path.\n";
$fp = fopen($file_path, "r+");
fwrite($fp, '// backed up: ' . time() . "\n");
fclose($fp);

copy($file_path, $file_path . "-copy");