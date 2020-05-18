<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Dex\Marketplace\Application\CreateUserAccount\CreateUserAccountRequest;
use Dex\Marketplace\Application\CreateUserAccount\CreateUserAccountService;
use Dex\Marketplace\Application\ForgotPasswordUser\ForgotPasswordUserRequest;
use Dex\Marketplace\Application\ForgotPasswordUser\ForgotPasswordUserService;
use Dex\Marketplace\Application\LoginUser\LoginUserRequest;
use Dex\Marketplace\Application\LoginUser\LoginUserService;
use Phalcon\Mvc\Controller;

class UserController extends Controller
{

    private CreateUserAccountService $createUserAccountService;
    private LoginUserService $loginUserService;
    private ForgotPasswordUserService $forgotPasswordUserService;

    public function initialize()
    {
        // TODO: CREATE SERVICE
        $this->createUserAccountService = $this->di->get('createUserAccountService');
        $this->loginUserService = $this->di->get('loginUserService');
        $this->forgotPasswordUserService = $this->di->get('forgotPasswordUserService');

        if ($this->session->has('username') && $this->session->has('fullname')) {
            $this->view->setVar('username', $this->session->get('username'));
            $this->view->setVar('fullname', $this->session->get('fullname'));
        }
    }

    public function indexAction()
    {
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
            $rememberMe = $request->getPost('remember-me');

            if (isset($rememberMe))
                $rememberMe = true;
            else
                $rememberMe = false;

            $request = new LoginUserRequest($username,
                $password,
                $rememberMe
            );

            $response = $this->loginUserService->execute($request);

            $response->getError() ?
                $this->flashSession->error($response->getMessage())
                :
                $this->flashSession->success($response->getMessage());

            return $this->response->redirect('/');
        }

        $this->view->setVar('title', 'Login Page');
        //TODO: Collection CSS/JS

        return $this->view->pick('user/login');
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
            $telp_number = $request->getPost('area_code', 'string') . $request->getPost('telp_no', 'string');
            $status_user = $request->getPost('status_user', 'string');


            $userRequest = new CreateUserAccountRequest(
                $username,
                $fullname,
                password_hash($password, PASSWORD_BCRYPT),
                $email,
                $address,
                $telp_number,
                strtoupper($status_user)
            );

            $response = $this->createUserAccountService->execute($userRequest);

            $response->getError() ? $this->flashSession->error($response->getCode() . ' ' . $response->getMessage()) :
                $this->flashSession->success($response->getMessage());

            return $this->response->redirect('/');
        }

        $this->view->setVar('title', 'Register Page');
        return $this->view->pick('user/register');
    }

    public function forgotPasswordAction()
    {
        if($this->request->isPost()){
            $email = $this->request->getPost('email', 'email');

            $req = new ForgotPasswordUserRequest($email);

            $res = $this->forgotPasswordUserService->execute($req);

            if($res->getError()){
                $this->flashSession->error($res->getMessage());
            }else{
                $this->flashSession->success($res->getMessage());
                return $this->response->redirect('/marketplace/user/verifyToken');
            }

        }
        $this->view->setVar('title', 'Forgot Password');
        return $this->view->pick('user/forgot');
    }

    public function verifyTokenAction()
    {
        if($this->request->isPost()){
            $token = $this->request->getPost('token');

            $req = new ForgotPasswordUserRequest('', true, $token);

            $res = $this->forgotPasswordUserService->execute($req);

            if($res->getError()){
                $this->flashSession->error($res->getMessage());
            }else{
                $this->session->set('resetPassword', true);
                return $this->response->redirect('/marketplace/user/resetPassword');
            }

            return $this->response->redirect('/marketplace/user/forgotPassword');
        }

        $this->view->setVar('title', 'Verify Token');
        return$this->view->pick('user/verify');
    }

    public function resetPasswordAction(){

        if($this->request->isPost()){
            $password = $this->request->getPost('password');
            $req = new ForgotPasswordUserRequest($this->session->get('email')
                , false, null, true, $password);

            $res = $this->forgotPasswordUserService->execute($req);

            if($res->getError()){
                $this->flashSession->error($res->getMessage());
                return $this->response->redirect('/');
            }
            $this->flashSession->success($res->getMessage());

            return $this->response->redirect('/marketplace/user/login');
        }

        $this->view->setVar('title', 'Reset Password');
        return $this->view->pick('user/reset');
    }

    public function logoutAction()
    {
        $this->cookies->set('rememberMe', null, time() - 3600);
        $this->cookies->delete('rememberMe');

        if ($this->session->has('user_id')) {
            $this->session->remove('user_id');
        }
        if ($this->session->has('username')) {
            $this->session->remove('username');
        }
        if ($this->session->has('fullname')) {
            $this->session->remove('fullname');
        }

        $this->flashSession->success('Logout success');
        return $this->response->redirect('/');

    }


}
