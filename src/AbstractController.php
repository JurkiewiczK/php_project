<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/ConfigurationException.php");

use App\Exception\ConfigurationException;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = "list";

    private static array $configuration = [];

    protected Database $database;
    protected Request $request;
    protected View $view;

    public static function initConfig(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {

        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException("Congif ERROR");
        };

        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        $action = $this->action() . 'Execute';
        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Execute';
        }
        $this->$action();
    }

    private function action(): string
    {
        return $action = $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}