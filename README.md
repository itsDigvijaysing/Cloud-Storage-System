# Cloud Computing Project

Encrypted personal cloud storage system built with PHP.

## Setup

1. Copy `.env.example` to `.env` and set a strong `STORAGE_KEY`.
2. Ensure PHP has the OpenSSL extension enabled.
3. Serve the project with a PHP-capable web server; `upload/` and `download/` are created automatically.

Files are stored encrypted in `upload/` and downloaded through `download.php`. Direct access to stored files is blocked when Apache `.htaccess` rules are enabled.

## Migration note

Files encrypted with the older base64 demo format are not compatible with the current AES-based storage. Delete old files in `upload/` and `download/` before using the new format, or keep a backup if you still need the legacy files.

## Website Link

https://encryptedstorage.000webhostapp.com/index.php

## Medium Link

https://digvijaysing.medium.com/my-cloud-computing-project-encrypted-personal-cloud-storage-system-a62a3434ff24
