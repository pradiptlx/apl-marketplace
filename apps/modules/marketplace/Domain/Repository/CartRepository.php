<?php


namespace Dex\Marketplace\Domain\Repository;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\UserId;

interface CartRepository
{

    public function byId(CartId $cartId): ?Cart;

    public function byBuyerId(UserId $userId);

    public function saveCart(Cart $cart);

    public function deleteCart(CartId $cartId);


}
