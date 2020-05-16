<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;

use Dex\Marketplace\Application\CreateProduct\CreateProductRequest;
use Dex\Marketplace\Application\CreateProduct\CreateProductService;
use Dex\Marketplace\Application\LoginUser\LoginUserRequest;
use Phalcon\Mvc\Controller;

class ProductController extends Controller
{

    private CreateProductService $createProductSerivce;

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

        $this->createProductSerivce = $this->di->get('createProductSerivce');
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
        $request = $this->request;

        if ($request->isPost()) {
            $productName = $request->getPost('productName', 'string');
            $stok = $request->getPost('stok');
            $price = $request->getPost('price');
            $description = $request->getPost('description');
            $sellerId = strval($this->session->get('user_id'));


            $request = new CreateProductRequest(
                $sellerId, 
                $price, 
                $description, 
                $stok, 
                $productName
            );

            $response = $this->createProductSerivce->execute($request);

            $response->getError() ?
                $this->flashSession->error($response->getMessage())
                :
                $this->flashSession->success($response->getMessage());

            return $this->response->redirect('/');
        }

        $this->view->setVar('title', 'Create Product');
        // //TODO: Collection CSS/JS

        $this->view->pick('product/create');
    }

    public function deleteProductAction()
    {

    }

    public function editProductAction()
    {

    }


}
