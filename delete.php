<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	exit('Method not allowed.');
}

$up_folder_path = "upload";
$down_folder_path = "download";

$upfiles = is_dir($up_folder_path) ? glob($up_folder_path . '/*') : [];
$downfiles = is_dir($down_folder_path) ? glob($down_folder_path . '/*') : [];

foreach ($upfiles as $file) {
	if (is_file($file)) {
		unlink($file);
	}
}
foreach ($downfiles as $file) {
	if (is_file($file)) {
		unlink($file);
	}
}

print("All files deleted successfully.");
echo "<meta http-equiv='refresh' content='2;url=index.php'/>";
