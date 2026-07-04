<?php

require_once __DIR__ . '/config.php';

$keyvalue = storageKey();
if ($keyvalue === '') {
	http_response_code(500);
	exit('Storage key not configured.');
}

$storedFile = basename($_GET['file'] ?? '');
if (!preg_match('/^[a-f0-9]{32}\.data$/', $storedFile)) {
	http_response_code(400);
	exit('Invalid file request.');
}

$filePath = 'upload/' . $storedFile;
if (!is_file($filePath)) {
	http_response_code(404);
	exit('File not found.');
}

$encryptedContent = file_get_contents($filePath);
$decryptedContent = decryptContent($encryptedContent, $keyvalue);
if ($decryptedContent === false) {
	http_response_code(500);
	exit('Unable to decrypt file.');
}

$downloadName = basename(originalFileName($storedFile));
$downloadName = preg_replace('/[^A-Za-z0-9._-]/', '_', $downloadName);
if ($downloadName === '') {
	$downloadName = 'download.bin';
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $downloadName . '"');
header('Content-Length: ' . strlen($decryptedContent));
echo $decryptedContent;
