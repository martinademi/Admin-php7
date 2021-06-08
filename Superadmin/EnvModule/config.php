<?php
//nano /etc/php/7.0/fpm/pool.d/www.conf

//env[ENV_DIR] = "/var/env"
//env[ENV_PATH] = ".envdev"

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = new Dotenv('/var/env', '.envdev');
$dotenv->load();

foreach ($_ENV as $key => $value) {
    define($key, $value);
}

?>