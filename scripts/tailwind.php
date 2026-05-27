<?php

/**
 * ejecuta tailwind css con los argumentos recibidos
 *
 * uso:
 *   php scripts/tailwind.php              -> compila una vez
 *   php scripts/tailwind.php --watch      -> modo vigilancia
 */

$args = implode(' ', array_slice($argv, 1));

if (PHP_OS_FAMILY === 'Windows') {
    $binary = 'tailwindcss.exe';
} else {
    $binary = './tailwindcss';
}

$command = sprintf(
    '%s -i input.css -o public/css/tailwind.css %s',
    $binary,
    $args
);

echo "> {$command}\n";
passthru($command, $exitCode);
exit($exitCode);
