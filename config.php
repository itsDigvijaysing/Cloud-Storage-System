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
