<?php
header('X-Proxy-Version: clean-2026-05-18');
// proxy.php

$token = '66d66caeed0864778097263cb9ee105e';

$allowed = [
    'layer',
    'tilematrixset',
    'Service',
    'Request',
    'Version',
    'Format',
    'TileMatrix',
    'TileCol',
    'TileRow',
];

$params = [];

foreach ($allowed as $key) {
    if (isset($_GET[$key])) {
        $params[$key] = $_GET[$key];
    }
}

$params['token'] = $token;

$serviceUrl = 'https://api.dataforsyningen.dk/wmts/natur_friluftskort?' . http_build_query($params);

$ch = curl_init($serviceUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: image/png,image/jpeg,*/*'
]);

$content = curl_exec($ch);

if ($content === false) {
    http_response_code(500);
    echo 'cURL Error: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

curl_close($ch);

if ($status >= 400 || empty($content)) {
    http_response_code(200);
    header('Content-Type: image/gif');
    echo base64_decode('R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=');
    exit;
}

http_response_code(200);

header('Content-Type: ' . ($type ?: 'image/jpeg'));
echo $content;
exit;