<?php

declare(strict_types=1);

namespace App;

require_once('src/Exceptions/ConfigurationException.php');
require_once("src/view.php");
require_once("src/database.php");

use App\Request;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

class Controller
{
    private const DEFAULT_ACTION = "list";

    private static array $configuration = [];

    private Database $database;
    private Request $request;
    private View $view;

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

        switch ($this->action()) {
            case 'create':
                $page = 'create';

                if ($this->request->postExist()) {
                    $noteData = [
                        'title' => $this->request->postParam('title'),
                        'description' => $this->request->postParam('description')
                    ];

                    $this->database->createNote($noteData);
                    header('Location: /php_project/?before=created');
                    exit();
                }
                break;

            case 'show':
                $page = 'show';

                $noteId = (int)($this->request->getParam('id'));

                if (!$noteId) {
                    header('Location: ./?error=noid');
                    exit();
                }

                try {
                    $singleNote = $this->database->getSingleNote($noteId);
                } catch (NotFoundException $e) {
                    header("Location: ./?error=notfound");
                    exit();
                }
                $viewParams = [
                    'note' => $singleNote,
                ];
                break;

            default:
                $page = 'list';
                $viewParams = [
                    'notes' => $this->database->downloadNotes(),
                    'before' => $this->request->getParam('before'),
                    'error' => $this->request->getParam('error')

                ];
                break;
        }

        $this->view->render($page, $viewParams ?? []);
    }

    private function action(): string
    {
        return $action = $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}