<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use App\Request;
use Throwable;

require_once("src/utils/debug.php");
require_once("src/AbstractController.php");
require_once("src/Controller.php");
require_once("src/Exceptions/AppException.php");
require_once("src/Request.php");

$config_db = require_once("./config/config.php");

$request = new Request($_GET, $_POST);

try {

    AbstractController::initConfig($config_db);
    (new Controller($request))->run();
} catch (StorageException $e) {
    echo "<h1>Wystąpił bład w aplikacji</h1>" . "</br>";
    echo $e->getMessage();
} catch (NotFoundException $e) {
    echo "<h1>Nie znaleziono zawartości.</h1>";
    echo $e->getMessage();
} catch (ConfigurationException $e) {
    dump($e);
    echo "<h1>Problem z konfiguracjąDB. Kontakt dasd@da.com</h1>";
} catch (AppException $e) {
    echo "<h1>Wystąpił bład w aplikacji</h1> ";
    echo $e->getMessage();
} catch (Throwable $e) {
    dump($e);
    echo '<h1>Wystąpił błąd appki </h1>';
};

