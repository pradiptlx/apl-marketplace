<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Phalcon\Mvc\Controller;

class ProductController extends Controller
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

        $this->view->pick('product/home');

    }

    public function detailProductAction()
    {

        $this->view->setVar('title', 'Detail Page');
        $this->view->pick('product/detail');
    }

    public function createProductAction()
    {

    }

    public function deleteProductAction()
    {

    }

    public function editProductAction()
    {

    }


}
