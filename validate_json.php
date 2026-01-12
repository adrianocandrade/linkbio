<?php
$json = file_get_contents('resources/lang/portugues.json');
$data = json_decode($json);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSON Error: ' . json_last_error_msg() . "\n";
    exit(1);
}
echo 'JSON is valid' . "\n";
