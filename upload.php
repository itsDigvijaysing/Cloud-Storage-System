<?php

require_once __DIR__ . '/config.php';

$uploadDirectory = "upload/";
$keyvalue = storageKey();

if ($keyvalue === '') {
	http_response_code(500);
	exit('Storage key not configured.');
}

if (!is_dir($uploadDirectory)) {
	mkdir($uploadDirectory, 0755, true);
}

$fileName = basename($_FILES['fileToUpload']['name']);
$tempFileName = $_FILES['fileToUpload']['tmp_name'];
$error = $_FILES['fileToUpload']['error'];

if ($error === UPLOAD_ERR_OK && $fileName !== '') {
	$file = fopen($tempFileName, "r");
	if ($file === false) {
		http_response_code(500);
		exit('Unable to read uploaded file.');
	}

	$content = fread($file, filesize($tempFileName));
	fclose($file);

	$encryptedContent = encryptContent($content, $keyvalue);
	if ($encryptedContent === false) {
		http_response_code(500);
		exit('Encryption failed.');
	}

	$storedName = md5($fileName) . ".data";
	$encryptedFileSaveName = $uploadDirectory . $storedName;
	$encryptedFile = fopen($encryptedFileSaveName, 'w');
	if ($encryptedFile === false) {
		http_response_code(500);
		exit('Unable to save encrypted file.');
	}

	fwrite($encryptedFile, $encryptedContent);
	fclose($encryptedFile);

	$metaFileSaveName = $uploadDirectory . md5($fileName) . ".meta";
	file_put_contents($metaFileSaveName, $fileName);

	print("Encrypted file uploaded successfully.");
} else {
	print("Error while uploading file.");
}

echo "<meta http-equiv='refresh' content='2;url=index.php'/>";
