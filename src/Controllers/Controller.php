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

        $viewParams = [
            'note' => $this->getNote(),
        ];

        $this->view->render($page, $viewParams ?? []);
    }

    public function listExecute(): void
    {
        $sortby = $this->request->getParam('sortby', 'title');
        $sortorder = $this->request->getParam('sortorder', 'desc');


        $this->view->render('list', 
        [
            'sort' => ['sortby' => $sortby,'sortorder' => $sortorder],
            'notes' => $this->database->downloadNotes($sortby, $sortorder),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error'),
        ]);
    }

    public function editExecute(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int)$this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];

            $this->database->editNote($noteId, $noteData);
            $this->redirect('./?', ['before' => 'edited']);
        }

        $noteId = (int)$this->request->getParam('id');
        $singleNote = $this->database->getSingleNote($noteId);

        $this->view->render('edit', ['note' => $singleNote]);
    }

    public function deleteExecute(): void
    {
        if ($this->request->isPost()) {
            $id = $this->request->postParam('id');
            $this->database->deleteNote($id);
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
            $singleNote = $this->database->getSingleNote($noteId);
        } catch (NotFoundException $e) {
            $this->redirect('./?', ['error' => 'notfound']);
        }
        return $singleNote;
    }
}
