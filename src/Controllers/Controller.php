<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exception\NotFoundException;
use PDO;

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

            $this->database->create($noteData);
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

        $viewParams = [
            'note' => $this->getNote(),
        ];

        $this->view->render($page, $viewParams ?? []);
    }

    public function listExecute()
    {
        $search = $this->request->getParam('search');
        $sortby = $this->request->getParam('sortby', 'title');
        $sortorder = $this->request->getParam('sortorder', 'desc');
        $note = $this->database->list($search, $sortby, $sortorder);

        if ($search) {
            $note = $note = $this->database->search($search, $sortby, $sortorder); 
        }
            $this->view->render(
                'list',
                [
                    'search' => $search,
                    'sort' => ['sortby' => $sortby, 'sortorder' => $sortorder],
                    'notes' => $note,
                    'before' => $this->request->getParam('before'),
                    'error' => $this->request->getParam('error'),
                ]
            );
    }

    public function editExecute(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int)$this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];

            $this->database->edit($noteId, $noteData);
            $this->redirect('./?', ['before' => 'edited']);
        }

        $noteId = (int)$this->request->getParam('id');
        $singleNote = $this->database->get($noteId);

        $this->view->render('edit', ['note' => $singleNote]);
    }

    public function deleteExecute(): void
    {
        if ($this->request->isPost()) {
            $id = $this->request->postParam('id');
            $this->database->delete($id);
            $this->redirect('./?', ['before' => 'deleted']);
            exit();
        }

        $this->view->render('delete', ['note' => $this->getNote()]);
    }


    final private function getNote(): array
    {
        $noteId = (int)($this->request->getParam('id'));
        if (!$noteId) {
            $this->redirect('./?', ['error' => 'noid']);
        }

        try {
            $singleNote = $this->database->get($noteId);
        } catch (NotFoundException $e) {
            $this->redirect('./?', ['error' => 'notfound']);
        }
        return $singleNote;
    }
}
