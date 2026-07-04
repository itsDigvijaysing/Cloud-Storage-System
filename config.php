<?php

function loadEnv($path)
{
	if (!file_exists($path)) {
		return;
	}

	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		$line = trim($line);
		if ($line === '' || $line[0] === '#') {
			continue;
		}

		$parts = explode('=', $line, 2);
		if (count($parts) !== 2) {
			continue;
		}

		$name = trim($parts[0]);
		$value = trim($parts[1]);
		if ($name === '' || getenv($name) !== false) {
			continue;
		}

		putenv("$name=$value");
		$_ENV[$name] = $value;
	}
}

loadEnv(__DIR__ . '/.env');

function storageKey()
{
	$key = getenv('STORAGE_KEY') ?: '';
	return $key !== false ? $key : '';
}

function encryptContent($content, $key)
{
	$iv = openssl_random_pseudo_bytes(16);
	$encrypted = openssl_encrypt(
		$content,
		'AES-256-CBC',
		hash('sha256', $key, true),
		OPENSSL_RAW_DATA,
		$iv
	);

	if ($encrypted === false) {
		return false;
	}

	return base64_encode($iv . $encrypted);
}

function decryptContent($encryptedContent, $key)
{
	$data = base64_decode($encryptedContent);
	if ($data === false || strlen($data) < 17) {
		return false;
	}

	$iv = substr($data, 0, 16);
	$payload = substr($data, 16);

	return openssl_decrypt(
		$payload,
		'AES-256-CBC',
		hash('sha256', $key, true),
		OPENSSL_RAW_DATA,
		$iv
	);
}

function originalFileName($storedFileName)
{
	$metaPath = 'upload/' . str_replace('.data', '.meta', $storedFileName);
	if (!is_file($metaPath)) {
		return $storedFileName;
	}

	$name = trim(file_get_contents($metaPath));
	return $name !== '' ? $name : $storedFileName;
}
