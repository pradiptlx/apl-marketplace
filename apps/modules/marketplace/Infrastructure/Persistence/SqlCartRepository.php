<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\CartRepository;
use Dex\Marketplace\Infrastructure\Persistence\Record\CartRecord;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

class SqlCartRepository extends \Phalcon\Di\Injectable implements CartRepository
{

    public function byId(CartId $cartId): ?Cart
    {
        $record = CartRecord::findFirstById($cartId->getId());

        if (!isset($record))
            return null;

        return $record;
    }

    public function byBuyerId(UserId $userId): array
    {
//        $query = "SELECT c.* FROM Dex\Marketplace\Infrastructure\Persistence\Record\CartRecord c WHERE c.user_id=:user_id:";
//        $query = "SELECT cart.id, cart.product_id, cart.user_id, p.product_name, p.description, p.price,
//                  u.username, u.fullname
//                  FROM Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p
//                  JOIN Dex\Marketplace\Infrastructure\Persistence\Record\CartRecord cart on cart.product_id=p.id
//                  JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id=p.user_id
//                  WHERE p.user_id=:user_id:";
        $query = "SELECT cart.id, cart.product_id, cart.user_id, p.product_name, p.description, p.price,
                u.username, u.fullname
                FROM Dex\Marketplace\Infrastructure\Persistence\Record\CartRecord cart
                JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id=cart.user_id
                JOIN Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p on p.id=cart.product_id
                WHERE cart.user_id=:user_id:";

        $model = $this->modelsManager->createQuery($query)->execute([
            'user_id' => $userId->getId()
        ]);
//        $model = $this->modelsManager->createQuery($query)->execute();

        $carts = [];

        foreach ($model as $cart) {
            if ($cart == null)
                return [];
            $carts[] = new Cart(
                new CartId($cart->id),
                new Product(
                    new ProductId($cart->product_id),
                    $cart->product_name,
                    $cart->description,
                    '',
                    '',
                    0,
                    $cart->price
                ),
                new User(
                    new UserId($cart->user_id),
                    $cart->username,
                    $cart->fullname,
                    '',
                    '',
                    '',
                    ''
                )
            );
        }
        return $carts;
    }

    public function saveCart(Cart $cart)
    {
        $trans = (new Manager())->get();

        $record = new CartRecord();
        $record->id = $cart->getId()->getId();
        $record->product_id = $cart->getProduct()->getId()->getId();
        $record->user_id = $cart->getBuyer()->getId()->getId();
        $record->created_at = (new \DateTime())->format('Y-m-d H:i:s');

        if ($record->save()) {
            $trans->commit();

            return true;
        }
        $trans->rollback();
        return new Failed($record->getMessages()[0]);
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
