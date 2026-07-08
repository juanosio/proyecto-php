<?php

/**
 * descarga automatica del binario de tailwind css v3
 * segun el sistema operativo del usuario
 *
 * se ejecuta automaticamente con: composer install
 * version fijada: v3.4.17 (ultima de la serie 3)
 *
 * para saltar la descarga: composer install --no-scripts
 * o definir: SKIP_TAILWIND=1
 */

if (getenv('SKIP_TAILWIND') === '1' || isset($_SERVER['SKIP_TAILWIND'])) {
    echo "descarga de tailwind omitida (SKIP_TAILWIND=1)\n";
    exit(0);
}

$releaseUrl = 'https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.17/tailwindcss';

$osMap = [
    'Windows' => 'windows-x64.exe',
    'Darwin'  => 'macos-arm64',
    'Linux'   => 'linux-x64',
];

$platform = PHP_OS_FAMILY;

if (!isset($osMap[$platform])) {
    echo "sistema operativo no reconocido: {$platform}\n";
    echo "descarga tailwind manualmente desde: https://github.com/tailwindlabs/tailwindcss/releases\n";
    exit(1);
}

$suffix     = $osMap[$platform];
$downloadUrl = $releaseUrl . '-' . $suffix;
$outputName = $platform === 'Windows' ? 'tailwindcss.exe' : 'tailwindcss';
$outputPath = __DIR__ . '/../' . $outputName;

// si ya existe, saltar
if (file_exists($outputPath)) {
    $size = filesize($outputPath);
    if ($size > 1000000) { // mayor a 1MB, parece valido
        echo "tailwind css ya existe ({$outputName}, {$size} bytes).\n";
        exit(0);
    }
    // si es muy pequeño, probablemente esta corrupto
    @unlink($outputPath);
}

$maxRetries = 3;
$timeout = 120; // 2 minutos por intento

for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
    echo "descargando tailwind css para {$platform} (intento {$attempt}/{$maxRetries})...\n";

    $ch = curl_init($downloadUrl);
    $fp = fopen($outputPath, 'wb');

    curl_setopt_array($ch, [
        CURLOPT_FILE           => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => $timeout,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_FAILONERROR    => true,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $success = curl_exec($ch);
    $error   = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    fclose($fp);

    if ($success && $httpCode === 200) {
        $size = filesize($outputPath);
        if ($size > 1000000) {
            if ($platform !== 'Windows') {
                chmod($outputPath, 0755);
            }
            echo "tailwind css descargado: {$outputName} ({$size} bytes)\n";
            exit(0);
        }
        @unlink($outputPath);
        echo "archivo muy pequeño, posible error.\n";
    } else {
        @unlink($outputPath);
        echo "error: {$error} (HTTP {$httpCode})\n";
    }

    if ($attempt < $maxRetries) {
        $wait = $attempt * 5;
        echo "reintentando en {$wait} segundos...\n";
        sleep($wait);
    }
}

echo "\nNo se pudo descargar tailwind css automaticamente.\n";
echo "Opciones:\n";
echo "  1. Descargar manualmente desde: https://github.com/tailwindlabs/tailwindcss/releases\n";
echo "  2. Copiar el archivo en la raiz del proyecto como 'tailwindcss.exe'\n";
echo "  3. Saltar con: set SKIP_TAILWIND=1 && composer install\n";
exit(1);
