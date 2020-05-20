<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Dex\Marketplace\Application\AddToCartBuyer\AddToCartBuyerRequest;
use Dex\Marketplace\Application\AddToCartBuyer\AddToCartBuyerService;
use Dex\Marketplace\Application\ShowCartUser\ShowCartUserRequest;
use Dex\Marketplace\Application\ShowCartUser\ShowCartUserService;
use Phalcon\Mvc\Controller;

class CartController extends Controller
{

    private AddToCartBuyerService $addToCartBuyerService;
    private ShowCartUserService $showCartUserService;

    public function initialize()
    {
        $this->addToCartBuyerService = $this->di->get('addToCartBuyerService');
        $this->showCartUserService = $this->di->get('showCartUserService');
    }

    public function addCartAction()
    {

        if ($this->request->isGet()) {
            $productId = $this->request->get('q');
            $req = new AddToCartBuyerRequest($productId, $this->session->get('user_id'));

            $res = $this->addToCartBuyerService->execute($req);

            if ($res->getError()) {
                $this->flashSession->error($res->getMessage());
            } else {
                $this->flashSession->success($res->getMessage());
            }
            return $this->response->redirect('/marketplace/product/detailProduct' . $productId);
        }


    }

    public function viewCartAction()
    {
        $userId = $this->session->get('user_id');

        $req = new ShowCartUserRequest($userId);
        $res = $this->showCartUserService->execute($req);

        return $this->response->setJsonContent($res->getData());

    }

    public function removeCartAction()
    {

    }

}
