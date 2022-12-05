<?php

declare(strict_types=1);

namespace App;

require_once('src/Exceptions/ConfigurationException.php');

use App\Exception\ConfigurationException;
use App\Exception\ConfiurationException;

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
                $created = false;

                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $created = true;

                    $this->database->createNote('das');
                    
                    $viewParams = [
                        'title' => $_POST['title'],
                        'description' => $data['description'],
                    ];
                    
                }

                $viewParams['created'] = $created;
                break;

            default:
                $page = 'list';
                $viewParams['resultList'] = 'lista ';

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
