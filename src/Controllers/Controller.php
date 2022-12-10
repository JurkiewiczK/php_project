<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exception\NotFoundException;

class Controller extends AbstractController
{
    
    public function createExecute(): void
    {
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

        $this->view->render($page, $viewParams ?? []);
    }

    public function showExecute(): void
    {
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

        $this->view->render($page, $viewParams ?? []);
    }

    public function listExecute(): void
    {
        $page = 'list';
        $viewParams = [
            'notes' => $this->database->downloadNotes(),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error')
        ];

        $this->view->render($page, $viewParams ?? []);
    }

}
