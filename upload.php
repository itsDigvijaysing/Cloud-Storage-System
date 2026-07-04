<?php

$uploadDirectory = "upload/";
$downloadDirectory = "download/";
$keyvalue = getenv('STORAGE_KEY') ?: '';

if ($keyvalue === '') {
	http_response_code(500);
	exit('Storage key not configured.');
}

if (!is_dir($uploadDirectory)) {
	mkdir($uploadDirectory, 0755, true);
}
if (!is_dir($downloadDirectory)) {
	mkdir($downloadDirectory, 0755, true);
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

	$iv = openssl_random_pseudo_bytes(16);
	$encrypted = openssl_encrypt(
		$content,
		'AES-256-CBC',
		hash('sha256', $keyvalue, true),
		OPENSSL_RAW_DATA,
		$iv
	);

	if ($encrypted === false) {
		http_response_code(500);
		exit('Encryption failed.');
	}

	$encryptedContent = base64_encode($iv . $encrypted);
	$encryptedFileSaveName = $uploadDirectory . md5($fileName) . ".data";
	$encryptedFile = fopen($encryptedFileSaveName, 'w');
	if ($encryptedFile === false) {
		http_response_code(500);
		exit('Unable to save encrypted file.');
	}

	fwrite($encryptedFile, $encryptedContent);
	fclose($encryptedFile);
	print("Encrypted file uploaded successfully.");

	$data = base64_decode($encryptedContent);
	$storedIv = substr($data, 0, 16);
	$storedPayload = substr($data, 16);
	$decryptedContent = openssl_decrypt(
		$storedPayload,
		'AES-256-CBC',
		hash('sha256', $keyvalue, true),
		OPENSSL_RAW_DATA,
		$storedIv
	);

	if ($decryptedContent === false) {
		http_response_code(500);
		exit('Decryption verification failed.');
	}

	$decryptedFileSaveName = $downloadDirectory . $fileName;
	$decryptedFile = fopen($decryptedFileSaveName, 'w');
	if ($decryptedFile === false) {
		http_response_code(500);
		exit('Unable to save decrypted file.');
	}

	fwrite($decryptedFile, $decryptedContent);
	fclose($decryptedFile);
} else {
	print("Error while uploading file.");
}

echo "<meta http-equiv='refresh' content='2;url=index.php'/>";
