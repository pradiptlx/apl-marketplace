<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;

use Dex\Marketplace\Application\ChangeStockProduct\ChangeStockProductRequest;
use Dex\Marketplace\Application\ChangeStockProduct\ChangeStockProductService;
use Dex\Marketplace\Application\GetProductBySellerId\GetProductBySellerIdRequest;
use Dex\Marketplace\Application\GetProductBySellerId\GetProductBySellerIdService;
use Dex\Marketplace\Domain\Model\User;
use Phalcon\Mvc\Controller;

class SellerController extends UserController
{

    protected $getProductBySellerIdService;
    private ChangeStockProductService $changeStockProductService;
    public function initialize()
    {
        parent::initialize();
        $this->getProductBySellerIdService = $this->di->get('getProductBySellerIdService');
        $this->changeStockProductService = $this->di->get('changeStockProductService');
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
        $this->view->setVar('products', $response->getData()['product']);
        $this->view->setVar('title', 'My Product');
        return $this->view->pick('seller/myproduct');

    }

    public function editStockAction()
    {
        $productId = $this->router->getParams()[0];
        if (!isset($productId))
            return $this->response->redirect('/');
        
        $request = $this->request;
        if ($request->isPost()) {
            $stock = $request->getPost('stok');
            
            $request = new ChangeStockProductRequest($productId, $stock);
            $response = $this->changeStockProductService->execute($request);
            
            if ($response->getError()) {
                $this->flashSession->error($response->getMessage());
                return $this->response->redirect('');
            } else {
                $this->flashSession->success('Change Stock success');
            }

            return $this->response->redirect('/');

        }

        return $this->response->redirect('/');

    }

}
