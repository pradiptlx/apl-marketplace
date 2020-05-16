<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Phalcon\Mvc\Controller;

class SellerController extends Controller
{

    public function initialize()
    {
        if ($this->cookies->has('rememberMe')){
            $rememberMe = json_decode(($this->cookies->get('rememberMe')->getValue()));
            $this->session->set('username', $rememberMe->username);
            $this->session->set('fullname', $rememberMe->fullname);
            $this->session->set('user_id', $rememberMe->user_id);
        }

        if($this->session->has('username') && $this->session->has('fullname')){
            $this->view->setVar('username', $this->session->get('username'));
            $this->view->setVar('fullname', $this->session->get('fullname'));
        }

    }

    public function indexAction()
    {
        $this->view->setVar('title', 'Dashboard');
        $this->view->pick('seller/dashboard');
    }

}
