<?php


namespace Dex\microblog\Presentation\Web\Controller;


use Dex\microblog\Core\Application\Request\CreatePostRequest;
use Dex\microblog\Core\Application\Request\FileManagerRequest;
use Dex\microblog\Core\Application\Service\CreatePostService;
use Phalcon\Http\Response\Exception;
use Phalcon\Mvc\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        if ($this->request->isGet()) {
            // TODO: Call response from Application
            return $this->view->pick('posts/home');
        }

        //TODO: Dispatch to postAction
    }

    public function createPostAction()
    {
        $request = $this->request;
        $user_id = $request->getPost('user_id', 'string') ?: $this->session->get('user_id');

        $files = $request->getPost('files') ? new FileManagerRequest(
            'filename',
            'path'
        ) :
            null;

        if ($request->isPost()) {
            $postRequest = new CreatePostRequest(
                $request->getPost('title', 'string'),
                $request->getPost('content', 'string'),
                $files,
                $user_id
            );

            // TODO: FIX Constructor
            $postService = new CreatePostService(
                $this->di->get('sqlPostRepository'),
                $this->di->get('sqlUserRepository')
            );

            $execute = $postService->execute($postRequest);

            if ($execute) {
                $this->flash->success("Success Create Post");
                //TODO: Redirect
                return $this->response->redirect('/microblog/');

            }
            // TODO: Create exception
            return new Exception("Error save post");

        }
    }

}
