<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Request;
use App\Model\MemoModel;
use App\View;
use App\Exception\ConfigurationException;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = "list";

    private static array $configuration = [];

    protected MemoModel $database;
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

        $this->database = new MemoModel(self::$configuration['db']);

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

    protected function redirect(string $to, array $params = null): void
    {
        foreach ($params as $key => $value) {
            $parameters = $key . '=' . $value;
        }
        $location =  $to . $parameters;
        header('Location:'. $location);
    }

    private function action(): string
    {
        return $action = $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}