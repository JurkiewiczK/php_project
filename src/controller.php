<?php

declare(strict_types=1);

namespace App;

require_once('src/Exceptions/ConfigurationException.php');

use App\Exception\ConfigurationException;

require_once("src/view.php");
require_once("src/database.php");



class Controller
{

    private const DEFAULT_ACTION = "list";

    private static array $configuration = [];

    private Database $database;
    private array $request;
    private View $view;


    public static function initConfig(array $configuration): void
    {
        self::$configuration = $configuration;
    }


    public function __construct(array $request)
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
        $viewParams = [];

        switch ($this->action()) {
            case 'create':
                $page = 'create';


                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $noteData = [
                        'title' => $data['title'],
                        'description' => $data['description']
                    ];

                    $this->database->createNote($noteData);
                    header('Location: /php_project/?before=created');
                }
                break;

            default:
                $page = 'list';

                $data = $this->getRequestGet();

                $viewParams['before'] = $data['before'] ?? null;

                break;
        }

        $this->view->render($page, $viewParams);
    }


    private function action(): string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }



    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }


    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }
}
