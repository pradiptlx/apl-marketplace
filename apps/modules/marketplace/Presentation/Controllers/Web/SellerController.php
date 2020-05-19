<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;

use Dex\Marketplace\Application\GetProductBySellerId\GetProductBySellerIdRequest;
use Dex\Marketplace\Application\GetProductBySellerId\GetProductBySellerIdService;
use Dex\Marketplace\Domain\Model\User;
use Phalcon\Mvc\Controller;

class SellerController extends UserController
{

    protected $getProductBySellerIdService;
    public function initialize()
    {
        parent::initialize();
        $this->getProductBySellerIdService = $this->di->get('getProductBySellerIdService');
        if($this->session->has('status_user') && strtoupper($this->session->get('status_user')) ===
            User::$BUYER){
            $this->flashSession->error("Can't Access Restricted Page");
            $this->response->redirect('/marketplace/');
        }


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

    public function myProductAction()
    {
        $sellerId = $this->router->getParams()[0];
        if (!isset($sellerId))
            return $this->response->redirect('/');
        
        $request = new GetProductBySellerIdRequest($sellerId);
        $response = $this->getProductBySellerIdService->execute($request);
        $this->view->setVar('products', $response->getData());
        $this->view->setVar('title', 'My Product');
        return $this->view->pick('seller/myproduct');

    }

}
