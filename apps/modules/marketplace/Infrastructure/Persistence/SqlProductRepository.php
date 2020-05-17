<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

class SqlProductRepository extends \Phalcon\Di\Injectable implements ProductRepository
{

    /*private function parsingRecord(ProductRecord $record): ?Product
    {

        return new Product(
            new ProductId($record->id),
            $record->product_name,
            $record->description,
            $record->created_at,
            $record->updated_at,
            $record->stock,
            $record->price,
            $record->wishlist_counter,
            new User(
                new UserId($record->user_id),

            )
        )

    }*/

    private function parsingSet(Resultset $result) {
        $products = [];

        foreach ($result as $product) {
            $products[] = new Product(
                new ProductId($product->id),
                $product->product_name,
                $product->description,
                $product->created_at,
                $product->updated_at,
                $product->stock,
                $product->price,
                $product->wishlist_counter,
                new User(
                    new UserId($product->user_id),
                    $product->username,
                    $product->fullname,
                    '',
                    $product->email,
                    $product->address,
                    $product->telp_no
                )
            );
        }
        return $products;
    }

    public function byId(ProductId $productId): ?Product
    {
        $query = "SELECT p.*, u.id as userId, u.username as username, u.fullname,
                u.email, u.telp_no
                FROM Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p
                JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id = p.user_id
                WHERE p.id=:id:";

        $productRecord = $this->modelsManager->createQuery($query)->execute([
            'id' => $productId->getId()
        ]);

        if (isset($productRecord))
            return new Product(
                new ProductId($productRecord->id),
                $productRecord->product_name,
                $productRecord->description,
                $productRecord->created_at,
                $productRecord->updated_at,
                $productRecord->stock,
                $productRecord->price,
                $productRecord->wishlist_counter,
                new User(
                    new UserId($productRecord->userId),
                    $productRecord->username,
                    $productRecord->fullname,
                    "",
                    $productRecord->email,
                    "",
                    $productRecord->telp_no
                )
            );

        return null;
    }

    public function bySellerId(UserId $userId)
    {
        $query = "SELECT p.id, p.product_name, p.description, p.created_at, p.updated_at,
                p.stock, p.price, p.wishlist_counter,
                p.user_id, u.username, u.fullname, u.email, u.address, u.telp_number, u.status_user
                FROM Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p
                JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id = p.user_id";

        $productSet = $this->modelsManager->createQuery($query)
            ->execute(
                [
                    'id' => $userId->getId()
                ]
            );

        return $this->parsingSet($productSet);
    }

    public function getAll()
    {
        $query = "SELECT p.id, p.product_name, p.description, p.created_at, p.updated_at,
                p.stock, p.price, p.wishlist_counter,
                p.user_id, u.username, u.fullname, u.email, u.address, u.telp_number, u.status_user
                FROM Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p
                JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id = p.user_id";
        $productSet = $this->modelsManager->createQuery($query)->execute();

        return $this->parsingSet($productSet);
    }

    public function saveProduct(Product $product)
    {
        $transx = (new Manager())->get();

        $productRecord = new ProductRecord();
        $productRecord->id = $product->getId()->getId();
        $productRecord->product_name = $product->getProductName();
        $productRecord->description = $product->getDescription();
        $productRecord->created_at = (new \DateTime())->format('Y-m-d H:i:s');
        $productRecord->updated_at = (new \DateTime())->format('Y-m-d H:i:s');
        $productRecord->stock = $product->getStock();
        $productRecord->price = $product->getPrice();
        $productRecord->wishlist_counter = $product->getWishlistCounter();
        $productRecord->user_id = $product->getSellerId()->getId();

        if ($productRecord->save()) {
            $transx->commit();

            return true;
        }


        $transx->rollback();
        return new Failed("Can't Save Product");
    }

    public function deleteProduct(ProductId $productId)
    {
        $transx = (new Manager())->get();

        $product = ProductRecord::find([
            'conditions' => 'id=:id',
            'binds' => [
                'id' => $productId->getId()
            ]
        ]);

        if (isset($product)) {
            if ($product->delete()) {
                $transx->commit();

                return true;
            }
        } else {
            return false;
        }

        $transx->rollback();
        return new Failed("Failed to delete product");
    }

    public function editProduct(ProductId $productId)
    {
        // TODO: Implement editProduct() method.
    }
}
