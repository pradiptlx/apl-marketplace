<?php


namespace Dex\Marketplace\Presentation\Controllers\Web;


use Dex\Marketplace\Application\AddToCartBuyer\AddToCartBuyerService;
use Phalcon\Mvc\Controller;

class CartController extends Controller
{

    private AddToCartBuyerService $addToCartBuyerService;

    public function initialize()
    {
        $this->addToCartBuyerService = $this->di->get('addToCartBuyerService');

    }

    public function addCartAction()
    {

    }

    public function removeCartAction()
    {

    }

}
