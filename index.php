<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use Throwable;

require_once("src/utils/debug.php");
require_once("src/controller.php");
require_once("src/Exceptions/AppException.php");


$config_db = require_once("./config/config.php");

$request = [
    'get' => $_GET,
    'post' => $_POST,
];

try {

    Controller::initConfig($config_db);
    (new Controller($request))->run();
} catch (StorageException $e) {
    echo "Storage exception";
    echo $e->getMessage();
} catch (ConfigurationException $e) {
    dump($e);
    echo "Problem z konfiguracjąDB. Kontakt dasd@da.com";
} catch (AppException $e) {
    echo "Wystąpił bład w aplikacji (AppException index.php)" . '</br>';
    echo $e->getMessage();
} catch (Throwable $e) {
    dump($e);   
    echo '<h1>Wystąpił błąd appki (throwable inedex.php)</h1>';
};
