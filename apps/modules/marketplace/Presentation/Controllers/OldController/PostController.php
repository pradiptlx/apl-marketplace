<?php


namespace Dex\Microblog\Presentation\Web\Controller;


use Dex\Microblog\Core\Application\Request\CreatePostRequest;
use Dex\Microblog\Core\Application\Request\CreateReplyRequest;
use Dex\Microblog\Core\Application\Request\DeletePostRequest;
use Dex\Microblog\Core\Application\Request\FileManagerRequest;
use Dex\Microblog\Core\Application\Request\ViewPostRequest;
use Dex\Microblog\Core\Application\Request\ViewReplyByPostRequest;
use Dex\Microblog\Core\Application\Service\CreatePostService;
use Dex\Microblog\Core\Application\Service\CreateReplyService;
use Dex\Microblog\Core\Application\Service\DeletePostService;
use Dex\Microblog\Core\Application\Service\ShowAllPostService;
use Dex\Microblog\Core\Application\Service\ViewPostService;
use Dex\Microblog\Core\Application\Service\ViewReplyByPostService;
use Phalcon\Http\Request\File;
use Phalcon\Mvc\Controller;

class PostController extends Controller
{
    private CreatePostService $createPostService;
    private ShowAllPostService $showAllPostService;
    private ViewPostService $viewPostService;
    private ViewReplyByPostService $viewReplyByPostService;
    private DeletePostService $deletePostService;
    private CreateReplyService $createReplyService;

    public function initialize()
    {
        $this->showAllPostService = $this->di->get('showAllService');
        $this->viewPostService = $this->di->get('viewPostService');
        $this->viewReplyByPostService = $this->di->get('viewReplyByPostService');
        $this->createPostService = $this->di->get('createPostService');
        $this->deletePostService = $this->di->get('deletePostService');
        $this->createReplyService = $this->di->get('createReplyService');


        if (!$this->session->has('user_id')) {
            $this->response->redirect('/user/login');
        }

        if ($this->session->has('user_id') && $this->session->has('username')) {
            $this->view->setVar('username', $this->session->get('username'));
            $this->view->setVar('user_id', $this->session->get('user_id'));
        }

        $postCssCollection = $this->assets->collection('postCss');
        $postCssCollection->addCss('/css/main.css');
    }

    /**
     * GET only
     */
    public function indexAction()
    {
        $this->view->setVar('title', 'Home');

        $response = $this->showAllPostService->execute();

        if (!$response->getError()) {
            $this->view->setVar('posts', $response->getData());
            $this->view->setVar('totalPost', sizeof($response->getData()));
        }

        return $this->view->pick('post/home');
    }

    public function createPostAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $title = $request->getPost('title', 'string');
            $content = $request->getPost('content', 'string');
            $user_id = $this->session->get('user_id');

            $fileRequests = [];
            if ($request->hasFiles()) {
                $files = $request->getUploadedFiles() ?: null;

                foreach ($files as $file) {
                    $fileRequests[] = $this->initializeFileManager($file);
                }
            }

            $requestPost = new CreatePostRequest(
                $title,
                $content,
                $fileRequests,
                $user_id
            );

            $response = $this->createPostService->execute($requestPost);

            if (!$response->getError()) {
                $this->flashSession->success($response->getMessage());
            } else {
                $this->flashSession->error($response->getMessage());
            }

            $this->response->redirect('/');
        }
    }

    public function viewPostAction()
    {
        $this->view->setVar('title', 'View Post');
        $request = $this->request;
        $this->session->set('last_url', $this->router->getControllerName() . '/' . $this->router->getActionName() . '/' . $this->router->getParams()[0]);

        $idPost = $this->router->getParams()[0];

        if (isset($idPost)) {
            $viewRequest = new ViewPostRequest($idPost);
            $viewReplyRequest = new ViewReplyByPostRequest($idPost);

            $responsePost = $this->viewPostService->execute($viewRequest);
            $responseReply = $this->viewReplyByPostService->execute($viewReplyRequest);

            if (!$responsePost->getError() && !$responseReply->getError()) {
                $this->view->setVar('post', $responsePost->getData());
                $this->view->setVar('reply', $responseReply->getData());
                $this->view->setVar('title', $responsePost->getData()->title);

                return $this->view->pick('post/viewPost');
            }
        }

        $this->flashSession->error('Post not found');
        return $this->response->redirect('/');
    }

    public function deletePostAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $postId = $request->getPost('postId', 'string');

            $requestDelete = new DeletePostRequest($postId);

            $responseDelete = $this->deletePostService->execute($requestDelete);

            if ($responseDelete->getError()) {
                $this->flashSession->error($responseDelete->getMessage());
            } else
                $this->flashSession->success($responseDelete->getMessage());
        }

        if ($this->session->has('last_url')) {
            $lastUrl = $this->session->get('last_url');
            if ($lastUrl == 'user/dashboard')
                return $this->response->redirect($lastUrl);
        }
        return $this->response->redirect('/');
    }

    public function replyPostAction()
    {
        $request = $this->request;
        $title = $request->getPost('title', 'string');
        $content = $request->getPost('content', 'string');
        $postId = $this->router->getParams()[0];
        $originalPostRequest = new ViewPostRequest($postId);
        $originalPostResponse = $this->viewPostService->execute($originalPostRequest);

        if ($request->isPost()) {
            $replyRequest = new CreateReplyRequest($title, $content, $originalPostResponse->getData());

            $replyResponse = $this->createReplyService->execute($replyRequest);

            if ($replyResponse->getError()) {
                $this->flashSession->error($replyResponse->getCode() . ' ' . $replyResponse->getMessage());
            } else
                $this->flashSession->success($replyResponse->getMessage());
        }

        if ($this->session->has('last_url')) {
            $lastUrl = $this->session->get('last_url');
            if ($lastUrl == 'user/dashboard')
                return $this->response->redirect($lastUrl);
        }
        return $this->response->redirect('/');
    }

    private function initializeFileManager(File $file)
    {
        return new FileManagerRequest(
            $file->getName(),
            $file
        );
    }

}
