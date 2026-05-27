<?php

/**
 * descarga automatica del binario de tailwind css v3
 * segun el sistema operativo del usuario
 *
 * se ejecuta automaticamente con: composer install
 * version fijada: v3.4.17 (ultima de la serie 3)
 */

$releaseUrl = 'https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.17/tailwindcss';

$osMap = [
    'Windows' => 'windows-x64.exe',
    'Darwin'  => 'macos-arm64',
    'Linux'   => 'linux-x64',
];

$platform = PHP_OS_FAMILY; // 'Windows', 'Darwin', 'Linux'

if (!isset($osMap[$platform])) {
    echo "sistema operativo no reconocido: {$platform}\n";
    echo "descarga tailwind manualmente desde: https://github.com/tailwindlabs/tailwindcss/releases\n";
    exit(1);
}

$suffix     = $osMap[$platform];
$downloadUrl = $releaseUrl . '-' . $suffix;

$outputName = $platform === 'Windows' ? 'tailwindcss.exe' : 'tailwindcss';

// si ya existe, saltar
if (file_exists(__DIR__ . '/../' . $outputName)) {
    $size = filesize(__DIR__ . '/../' . $outputName);
    echo "tailwind css ya existe ({$outputName}, {$size} bytes).\n";
    exit(0);
}

echo "descargando tailwind css para {$platform}...\n";

$ch = curl_init($downloadUrl);
$fp = fopen(__DIR__ . '/../' . $outputName, 'wb');

curl_setopt_array($ch, [
    CURLOPT_FILE           => $fp,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT        => 300,
    CURLOPT_FAILONERROR    => true,
]);

$success = curl_exec($ch);
$error   = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);
fclose($fp);

if (!$success) {
    @unlink(__DIR__ . '/../' . $outputName);
    echo "error al descargar tailwind (http {$httpCode}): {$error}\n";
    echo "descargalo manualmente desde: https://github.com/tailwindlabs/tailwindcss/releases\n";
    exit(1);
}

// hacer ejecutable en mac/linux
if ($platform !== 'Windows') {
    chmod(__DIR__ . '/../' . $outputName, 0755);
}

echo "tailwind css descargado correctamente: {$outputName}\n";
