<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Phalcon\Mvc\Controller;

class ProductController extends Controller
{

    public function initialize()
    {

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
