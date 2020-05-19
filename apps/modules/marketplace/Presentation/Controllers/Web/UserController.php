<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Dex\Marketplace\Application\ChangeProfileUser\ChangeProfileUserRequest;
use Dex\Marketplace\Application\ChangeProfileUser\ChangeProfileUserService;
use Dex\Marketplace\Application\CreateUserAccount\CreateUserAccountRequest;
use Dex\Marketplace\Application\CreateUserAccount\CreateUserAccountService;
use Dex\Marketplace\Application\ForgotPasswordUser\ForgotPasswordUserRequest;
use Dex\Marketplace\Application\ForgotPasswordUser\ForgotPasswordUserService;
use Dex\Marketplace\Application\LoginUser\LoginUserRequest;
use Dex\Marketplace\Application\LoginUser\LoginUserService;
use Dex\Marketplace\Application\ShowProfileUser\ShowProfileUserService;
use Phalcon\Mvc\Controller;

class UserController extends Controller
{

    private CreateUserAccountService $createUserAccountService;
    private LoginUserService $loginUserService;
    private ForgotPasswordUserService $forgotPasswordUserService;
    private ShowProfileUserService $showProfileUserService;
    private ChangeProfileUserService $changeProfileUserService;

    public function initialize()
    {
        $this->createUserAccountService = $this->di->get('createUserAccountService');
        $this->loginUserService = $this->di->get('loginUserService');
        $this->forgotPasswordUserService = $this->di->get('forgotPasswordUserService');
        $this->showProfileUserService = $this->di->get('showProfileUserService');
        $this->changeProfileUserService = $this->di->get('changeProfileUserService');

        if ($this->session->has('username') && $this->session->has('fullname')
            && $this->session->has('status_user')) {
            $this->view->setVar('username', $this->session->get('username'));
            $this->view->setVar('fullname', $this->session->get('fullname'));
            $this->view->setVar('status_user', $this->session->get('status_user'));
            $this->view->setVar('user_id', $this->session->get('user_id'));
        }
    }

    public function dashboardAction()
    {
        if (strtoupper($this->session->get('status_user')) === 'SELLER') {
            return $this->response->redirect('/marketplace/seller');
        } elseif (strtoupper($this->session->get('status_user')) === 'BUYER') {
            return $this->response->redirect('/marketplace/user/profile');
        } else {
            $this->dispatcher->forward(
                [
                    'namespace' => 'Dex\Marketplace\Presentation\Controllers\Web',
                    'modules' => 'marketplace',
                    'controllers' => 'user',
                    'action' => 'login'
                ]
            );
        }
    }

    public function profileAction()
    {
        $request = $this->request;

        if ($request->isPost()) {
            $username = $request->getPost('username');
            $fullname = $request->getPost('fullname');
            $status_user = $request->getPost('status_user');
            $email = $request->getPost('email');
            $address = $request->getPost('address');
            $telp_number = $request->getPost('telp_number');
            $new_pass = $request->getPost('new_pass');

            $req = new ChangeProfileUserRequest(
                $this->session->get('user_id'),
                $username,
                $fullname,
                $status_user,
                $email,
                $address,
                $telp_number,
                $new_pass
            );

            $res = $this->changeProfileUserService->execute($req);

            if($res->getError()){
                $this->flashSession->error($res->getMessage());
                return $this->response->redirect('');
            }else{
                $this->flashSession->success($res->getMessage());
                return $this->response->redirect('');
            }

        } else {
            $res = $this->showProfileUserService->execute();
            if ($res->getError() && $res->getCode() === 500) {
                $this->flashSession->error($res->getMessage());
                return $this->response->redirect('/marketplace/');
            }
            //elseif ($res->getError() && $res->getCode() === 200){ // Wishlist not found
            //                $this->flashSession->error($res->getMessage());
            //            }

            $this->view->setVar('user', $res->getData()['user']);
            $this->view->setVar('wishlist', $res->getData()['wishlist']);
        }

        $this->view->setVar('title', 'Profile Page ' . $this->session->get('fullname'));
        $this->view->pick('user/profile');
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

            if ($response->getError()) {
                $this->flashSession->error($response->getMessage());
                return $this->response->redirect('/marketplace/user/login');
            } else
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
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email', 'email');

            $req = new ForgotPasswordUserRequest($email);

            $res = $this->forgotPasswordUserService->execute($req);

            if ($res->getError()) {
                $this->flashSession->error($res->getMessage());
            } else {
                $this->flashSession->success($res->getMessage());
                return $this->response->redirect('/marketplace/user/verifyToken');
            }

        }
        $this->view->setVar('title', 'Forgot Password');
        return $this->view->pick('user/forgot');
    }

    public function verifyTokenAction()
    {
        if ($this->request->isPost()) {
            $token = $this->request->getPost('token');

            $req = new ForgotPasswordUserRequest('', true, $token);

            $res = $this->forgotPasswordUserService->execute($req);

            if ($res->getError()) {
                $this->flashSession->error($res->getMessage());
            } else {
                $this->session->set('resetPassword', true);
                return $this->response->redirect('/marketplace/user/resetPassword');
            }

            return $this->response->redirect('/marketplace/user/forgotPassword');
        }

        $this->view->setVar('title', 'Verify Token');
        return $this->view->pick('user/verify');
    }

    public function resetPasswordAction()
    {

        if ($this->request->isPost()) {
            $password = $this->request->getPost('password');
            $req = new ForgotPasswordUserRequest($this->session->get('email')
                , false, null, true, $password);

            $res = $this->forgotPasswordUserService->execute($req);

            if ($res->getError()) {
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
