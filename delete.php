<?php
$up_folder_path = "upload";
$down_folder_path = "download";

// List of name of files inside
$upfiles = glob($up_folder_path.'/*');
$downfiles = glob($down_folder_path.'/*');

// Deleting all the files in the list
foreach($upfiles as $file) {

	if(is_file($file))
		// Delete the given file
		unlink($file);
}
foreach($downfiles as $file) {

	if(is_file($file))
		// Delete the given file
		unlink($file);
}
print("All Files are Deleted Successfully.");

echo "<meta http-equiv='refresh' content='2;url=index.php'/>";
?>
