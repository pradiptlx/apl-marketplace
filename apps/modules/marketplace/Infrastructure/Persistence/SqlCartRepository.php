<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\CartRepository;
use Dex\Marketplace\Infrastructure\Persistence\Record\CartRecord;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

class SqlCartRepository extends \Phalcon\Di\Injectable implements CartRepository
{

    public function byId(CartId $cartId): ?Cart
    {
        // TODO: Implement byId() method.
    }

    public function byBuyerId(UserId $userId): ?Cart
    {
        // TODO: Implement byBuyerId() method.
    }

    public function saveCart(Cart $cart)
    {
        // TODO: Implement saveCart() method.
    }

    public function deleteCart(CartId $cartId)
    {
        $transx = (new Manager())->get();

        $cart = CartRecord::findById($cartId->getId());

        if (isset($cart)) {
            if ($cart->delete()) {
                $transx->commit();

                return true;
            }
        } else {
            return false;
        }

        $transx->rollback();

        return new Failed("Failed Delete Cart Product");
    }
}
