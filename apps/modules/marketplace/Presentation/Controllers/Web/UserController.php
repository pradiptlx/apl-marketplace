<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Dex\Marketplace\Application\CreateUserAccount\CreateUserAccountRequest;
use Dex\Marketplace\Application\CreateUserAccount\CreateUserAccountService;
use Phalcon\Mvc\Controller;

class UserController extends Controller
{

    private CreateUserAccountService $createUserAccountService;

    public function initialize()
    {
        // TODO: CREATE SERVICE
        $this->createUserAccountService = $this->di->get('createUserAccountService');

    }

    public function indexAction(){
        $this->dispatcher->forward([
            'namespace' => 'Dex\Marketplace\Presentation\Controllers\Web',
            'module' => 'marketplace',
            'controller' => 'user',
            'action' => 'login'
        ]);
    }

    public function loginAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $username = $request->getPost('username', 'string');
            $password = $request->getPost('password', 'string');


        }

        $this->view->setVar('title', 'Login Page');
        //TODO: Collection CSS/JS

        $this->view->pick('user/login');
    }

    public function registerAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $username = $request->getPost('username', 'string');
            $fullname = $request->getPost('fullname', 'string');
            $password = $request->getPost('password', 'string');
            $email = $request->getPost('email', 'email');
            $address = $request->getPost('address');
            $telp_no = $request->getPost('telp_no', 'string');
            $status_user = $request->getPost('status_user', 'string');


            $userRequest = new CreateUserAccountRequest(
                $username,
                $fullname,
                $password,
                $email,
                $address,
                $telp_no,
                strtoupper($status_user)
            );

            $response = $this->createUserAccountService->execute($userRequest);

            $response->getError() ? $this->flashSession->error($response->getCode() . ' ' . $response->getMessage()) :
                $this->flashSession->success($response->getMessage());

            return $this->response->redirect('/');
        }

        $this->view->setVar('title', 'Register Page');
        //TODO: CSS/JS
        return $this->view->pick('user/register');
    }

}
