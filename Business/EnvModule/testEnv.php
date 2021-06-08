<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = new Dotenv('/var/env', '.envdev');
$dotenv->load();

echo "<pre>";

print_r($_ENV);
?>