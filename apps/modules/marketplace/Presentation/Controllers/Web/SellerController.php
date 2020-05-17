<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Phalcon\Mvc\Controller;

class SellerController extends UserController
{

    public function initialize()
    {
        parent::initialize();

//        if($this->session->has('username') && $this->session->has('fullname')){
//            $this->view->setVar('username', $this->session->get('username'));
//            $this->view->setVar('fullname', $this->session->get('fullname'));
//        }

    }

    public function indexAction()
    {
        $this->view->setVar('title', 'Dashboard');
        $this->view->pick('seller/dashboard');
    }

}
