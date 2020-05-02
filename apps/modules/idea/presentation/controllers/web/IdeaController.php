<?php

namespace Idy\Idea\Presentation\Controllers\Web;

use Idy\Idea\Application\CreateNewIdea\CreateNewIdeaRequest;
use Idy\Idea\Application\CreateNewIdea\CreateNewIdeaService;
use Idy\Idea\Application\RateIdea\RateIdeaRequest;
use Idy\Idea\Application\RateIdea\RateIdeaService;
use Idy\Idea\Application\ViewAllIdeas\ViewAllIdeasService;
use Idy\Idea\Application\VoteIdea\VoteIdeaRequest;
use Idy\Idea\Application\VoteIdea\VoteIdeaService;
use Phalcon\Mvc\Controller;

class IdeaController extends Controller
{
    /**
     * @var ViewAllIdeasService $viewAllIdeasService
     */
    protected $viewAllIdeasService;
    /**
     * @var CreateNewIdeaService $createNewIdeaService
     */
    protected $createNewIdeaService;
    /**
     * @var VoteIdeaService $voteIdeaService
     */
    protected $voteIdeaService;
    /**
     * @var RateIdeaService $rateIdeaService
     */
    protected $rateIdeaService;

    public function initialize()
    {
        $this->viewAllIdeasService = $this->di->get('viewAllIdeasService');
        $this->createNewIdeaService = $this->di->get('createNewIdeaService');
        $this->voteIdeaService = $this->di->get('voteIdeaService');
        $this->rateIdeaService = $this->di->get('rateIdeaService');
    }

    protected function send($data, $code = 200, $message = 'OK')
    {
        $this->response->setContentType('application/json');

        $json = json_encode($data, JSON_PRETTY_PRINT);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to convert server response to JSON: ' . json_last_error_msg());
        }

        $this->response->setStatusCode($code, $message);
        $this->response->setContent($json);
        $this->response->send();
    }

    public function indexAction()
    {
        $response = $this->viewAllIdeasService->handle();
        $this->view->ideas = $response->get();

        return $this->view->pick('home');
    }

    public function addPageAction()
    {
        return $this->view->pick('add');
    }

    public function addAction()
    {
        $ideaTitle = $this->request->getPost('ideaTitle');
        $ideaDescription = $this->request->getPost('ideaDescription');
        $authorName = $this->request->getPost('authorName');
        $authorEmail = $this->request->getPost('authorEmail');

        $request = new CreateNewIdeaRequest($ideaTitle, $ideaDescription, $authorName, $authorEmail);
        $response = $this->createNewIdeaService->handle($request);

        $response->getError()
            ? $this->flashSession->error($response->getMessage())
            : $this->flashSession->success($response->getMessage());

        return $this->response->redirect('');

    }

    public function voteAction()
    {
        $request = new VoteIdeaRequest($this->request->getPost('ideaId'));
        $response = $this->voteIdeaService->handle($request);

        $response->getError()
            ? $this->flashSession->error($response->getMessage())
            : $this->flashSession->success($response->getMessage());

        return $this->response->redirect('');
    }

    public function rateAction()
    {
        $ideaId = $this->request->getPost('ideaId');
        $value = $this->request->getPost('value');
        $name = $this->request->getPost('name');

        $request = new RateIdeaRequest($ideaId, $value, $name);
        $response = $this->rateIdeaService->handle($request);

        return $this->send($response->getMessage(), $response->getCode());
    }

}