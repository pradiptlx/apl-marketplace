<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\ProductImage;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Model\Wishlist;
use Dex\Marketplace\Domain\Model\WishlistId;
use Dex\Marketplace\Domain\Repository\WishlistRepository;
use Dex\Marketplace\Infrastructure\Persistence\Record\WishlistRecord;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

class SqlWishlistRepository extends \Phalcon\Di\Injectable implements WishlistRepository
{
    private function parsingResult(Resultset $wishlistResult)
    {
        $wishlists = [];
        foreach ($wishlistResult as $wishlist) {
            if ($wishlist == null)
                return [];
            $wishlists[] = new Wishlist(
                new WishlistId($wishlist->id),
                new Product(
                    new ProductId($wishlist->product_id),
                    $wishlist->product_name,
                    $wishlist->description,
                    '',
                    '',
                    $wishlist->stock,
                    $wishlist->price,
                    $wishlist->wishlist_counter,
                    $wishlist->cart_counter,
                    null
                ),
                new User(
                    new UserId($wishlist->user_id),
                    $wishlist->username,
                    $wishlist->fullname,
                    $wishlist->password,
                    $wishlist->email,
                    $wishlist->address,
                    $wishlist->telp_number,
                )
            );
        }

        return $wishlists;
    }

    public function byId(WishlistId $wishlistId): ?Wishlist
    {
        $query = "SELECT w.id, w.user_id, w.product_id , p.product_name, p.description, p.price, p.stock, p.wishlist_counter, p.image_path,
                  u.username, u.fullname, u.email, u.password, u.status_user, u.telp_number, u.address
                  FROM Dex\Marketplace\Infrastructure\Persistence\Record\WishlistRecord w
                  JOIN Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p on p.id=w.product_id
                  JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id=w.user_id
                 ";

        $wishlistResult = $this->modelsManager->createQuery($query)->execute();


        return $this->parsingResult($wishlistResult)[0];
    }

    public function byUserId(UserId $userId)
    {
        $query = "SELECT w.id, w.user_id, w.product_id , p.product_name, p.description, p.price, p.stock, p.wishlist_counter, p.image_path,
                  u.username, u.fullname, u.email, u.password, u.status_user, u.telp_number, u.address
                  FROM Dex\Marketplace\Infrastructure\Persistence\Record\WishlistRecord w
                  JOIN Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p on p.id=w.product_id
                  JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id=w.user_id
                  WHERE w.user_id=:userId:";
        $wishlistResult = $this->modelsManager->createQuery($query)
            ->execute([
                'userId' => $userId->getId()
            ]);

        return $this->parsingResult($wishlistResult);
    }

    public function saveWishlist(Wishlist $wishlist)
    {
        $trans = (new Manager())->get();

        $wishlistRecord = new WishlistRecord();
        $wishlistRecord->id = $wishlist->getId()->getId();
        $wishlistRecord->product_id = $wishlist->getProduct()->getId()->getId();
        $wishlistRecord->user_id = $wishlist->getUser()->getId()->getId();

        if ($wishlistRecord->save()) {
            $trans->commit();
            return true;
        }

        $trans->rollback();
        return new Failed($wishlistRecord->getMessages()[0]);
    }

    public function deleteWishlist(WishlistId $id)
    {
        $trans = (new Manager())->get();
        $wishlist = WishlistRecord::findFirstById($id->getId());

        if (isset($wishlist)) {
            if ($wishlist->delete()) {
                $trans->commit();
                return true;
            } else {
                $trans->rollback();
                return new Failed($wishlist->getMessages()[0]);
            }
        }

        return false;
    }
}
