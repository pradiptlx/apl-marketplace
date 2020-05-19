<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;

use Dex\Marketplace\Application\AddItemToWishlistBuyer\AddItemToWishlistBuyerRequest;
use Dex\Marketplace\Application\AddItemToWishlistBuyer\AddItemToWishlistBuyerService;
use Dex\Marketplace\Application\CreateProduct\CreateProductRequest;
use Dex\Marketplace\Application\CreateProduct\CreateProductService;
use Dex\Marketplace\Application\DeleteProduct\DeleteProductRequest;
use Dex\Marketplace\Application\DeleteProduct\DeleteProductService;
use Dex\Marketplace\Application\LoginUser\LoginUserRequest;

use Dex\Marketplace\Application\ListItemsBuyer\ListItemsBuyerService;
use Dex\Marketplace\Application\SearchProduct\SearchProductRequest;
use Dex\Marketplace\Application\SearchProduct\SearchProductService;
use Dex\Marketplace\Application\ShowItemDetailBuyer\ShowItemDetailBuyerRequest;
use Dex\Marketplace\Application\ShowItemDetailBuyer\ShowItemDetailBuyerService;
use Phalcon\Mvc\Controller;

class ProductController extends Controller
{
    private ListItemsBuyerService $listItemsBuyerService;
    private ShowItemDetailBuyerService $showItemDetailBuyerService;
    private CreateProductService $createProductService;
    private SearchProductService $searchProductService;
<<<<<<< HEAD
    private DeleteProductService $deleteProductService;
=======
    private AddItemToWishlistBuyerService $addItemToWishlistBuyerService;
>>>>>>> 6446a7e50a36daa04327b213e9f6ae941de1a390

    public function initialize()
    {
        $this->listItemsBuyerService = $this->di->get('listItemsBuyerService');
        $this->showItemDetailBuyerService = $this->di->get('showItemDetailBuyerService');
        $this->createProductService = $this->di->get('createProductService');
        $this->searchProductService = $this->di->get('searchProductService');
<<<<<<< HEAD
        $this->deleteProductService = $this->di->get('deleteProductService');
=======
        $this->addItemToWishlistBuyerService = $this->di->get('addItemToWishlistBuyerService');
>>>>>>> 6446a7e50a36daa04327b213e9f6ae941de1a390

        if ($this->cookies->has('rememberMe')) {
            $rememberMe = json_decode(($this->cookies->get('rememberMe')->getValue()));
            $this->session->set('username', $rememberMe->username);
            $this->session->set('fullname', $rememberMe->fullname);
            $this->session->set('user_id', $rememberMe->user_id);
        }

        if ($this->session->has('username') && $this->session->has('fullname')) {
            $this->view->setVar('username', $this->session->get('username'));
            $this->view->setVar('fullname', $this->session->get('fullname'));
        }

    }

    public function indexAction()
    {
        $response = $this->listItemsBuyerService->execute();

        $response->getError() ? $this->flashSession->error($response->getMessage())
            : $this->view->setVar('products', $response->getData());
        $this->view->pick('product/home');

    }

    public function detailProductAction()
    {
        $productId = $this->router->getParams()[0];
        if (!isset($productId))
            return $this->response->redirect('/');

        $request = new ShowItemDetailBuyerRequest($productId);
        $response = $this->showItemDetailBuyerService->execute($request);

        if ($response->getError()) {
            $this->flashSession->error($response->getMessage());
            return $this->response->redirect('/');
        }

        $this->view->setVar('product', $response->getData());
        $this->view->setVar('title', 'Detail Page');
        return $this->view->pick('product/detail');
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

            $response = $this->createProductService->execute($request);

            if ($response->getError()) {
                $this->flashSession->error($response->getMessage());
                return $this->response->redirect('');
            } else {
                $this->flashSession->success($response->getMessage());
            }

            return $this->response->redirect('/');
        }

        $this->view->setVar('title', 'Create Product');
        // //TODO: Collection CSS/JS

        return $this->view->pick('product/create');
    }

    public function deleteProductAction()
    {
        $productId = $this->router->getParams()[0];
        if (!isset($productId))
            return $this->response->redirect('/');
           
        $request = new DeleteProductRequest($productId);
        $response = $this->deleteProductService->execute($request);

        if ($response->getError()) {
            $this->flashSession->error($response->getMessage());
            return $this->response->redirect('/');
        }

        $this->flashSession->success('Delete Product success');
        $this->response->redirect('marketplace/seller');
       
    }

    public function editProductAction()
    {

    }

    public function searchProductAction()
    {
        $keyword = $this->request->get('q');
        $req = new SearchProductRequest($keyword);

        $res = $this->searchProductService->execute($req);

        return $this->response->setJsonContent($res->getData());

    }

    public function addToWishlistAction()
    {
        $productId = $this->router->getParams()[0];
        $userId = $this->session->get('user_id');

        $req = new AddItemToWishlistBuyerRequest($productId, $userId);

        $res = $this->addItemToWishlistBuyerService->execute($req);

        if($res->getError()){
            $this->flashSession->error($res->getMessage());
        }else{
            $this->flashSession->success($res->getMessage());
        }

        return $this->response->redirect('');
    }

}
