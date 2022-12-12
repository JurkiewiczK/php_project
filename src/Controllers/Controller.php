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
            $this->redirect('./?', ['before' => 'created']);
        }

        $this->view->render($page, $viewParams ?? []);
    }

    public function showExecute(): void
    {
        $page = 'show';

        $noteId = (int)($this->request->getParam('id'));

        if (!$noteId) {
            $this->redirect('./?', ['error' => 'noid']);
        }

        try {
            $singleNote = $this->database->getSingleNote($noteId);
        } catch (NotFoundException $e) {
            $this->redirect('./?', ['error' => 'notfound']);
        }
        $viewParams = [
            'note' => $singleNote,
        ];

        $this->view->render($page, $viewParams ?? []);
    }

    public function listExecute(): void
    {

        $this->view->render('list', [
            'notes' => $this->database->downloadNotes(),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error'),
        ]);
    }

    public function editExecute()
    {
        if ($this->request->isPost()) {
            $noteId=(int)$this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];

            $this->database->editNote($noteId, $noteData);
            $this->redirect('./?', ['before' =>'edited']);
        }

        $noteId = (int)$this->request->getParam('id');
       $singleNote = $this->database->getSingleNote($noteId);

        $this->view->render('edit', ['note' => $singleNote]);
    }
}