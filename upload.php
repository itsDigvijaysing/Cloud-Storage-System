<?php //code for save_file.php

$uploadDirectory = "upload/";
$downloadDirectory ="download/";
$keyvalue="abcde";
$fileName = $_FILES['fileToUpload']['name']; 
$tempFileName = $_FILES['fileToUpload']['tmp_name'];
$error = $_FILES['fileToUpload']['error']; 
$fileContentType = $_FILES['fileToUpload']['type']; 
$fileSize = $_FILES['fileToUpload']['size'];
if($error==UPLOAD_ERR_OK){
	$file = fopen($tempFileName,"r"); 
	$content = fread($file,filesize($tempFileName));
	$encryptedContent = base64_encode($content);
	$encryptedContent = $keyvalue.$encryptedContent;
	$encryptedFileSaveName=$uploadDirectory.md5($fileName).".data";
	$encryptedFile = fopen($encryptedFileSaveName,'w');
	fwrite($encryptedFile,$encryptedContent); 
	fclose($encryptedFile); 
	print("Encrypted File has been Upload Successfully.");

	$file1 = fopen($encryptedFileSaveName,"r"); 
	$content1 = fread($file1,filesize($encryptedFileSaveName));
	$content1 = ltrim($content1, $keyvalue);
	$decryptedContent = base64_decode($content1);
	$decryptedFileSaveName=$downloadDirectory.$fileName;
	$decryptedFile = fopen($decryptedFileSaveName,'w');
	fwrite($decryptedFile,$decryptedContent); 
	fclose($decryptedFile);
}
else
{
	print("Error while uploading file"); 
}

echo "<meta http-equiv='refresh' content='2;url=index.php'/>";
?>