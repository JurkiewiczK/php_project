<?php

declare(strict_types=1);

spl_autoload_register(function (string $name) {
    $path = str_replace(["\\", "App/"], ["/", ""], $name);
    $path = "src/$path.php";
    require_once($path);
});

require_once("src/utils/debug.php");
$config_db = require_once("./config/config.php");

use App\Controllers\AbstractController;
use App\Controllers\Controller;
use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Exception\StorageException;


$request = new Request($_GET, $_POST, $_SERVER);

try {

    AbstractController::initConfig($config_db);
    (new Controller($request))->run();
} catch (ConfigurationException $e) {
    dump($e);
    echo "<h1>Problem z konfiguracjąDB. Kontakt dasd@da.com</h1>";
} catch (AppException $e) {
    echo "<h1>Wystąpił bład w aplikacji</h1> ";
    echo $e->getMessage();
} catch (NotFoundException $e) {
    echo "<h1>Wystąpił bład w aplikacji</h1> ";
    echo $e->getMessage();
} catch (\Throwable $e) {
    dump($e);
    echo '<h1>Wystąpił błąd appki </h1>';
}catch (StorageException $e) {
    dump($e);
    echo '<h1>Wystąpił błąd DB</h1>';
};
