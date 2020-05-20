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

    private function parsingSet(Resultset $result)
    {
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
                $product->image_path,
                new User(
                    new UserId($product->user_id),
                    $product->username,
                    $product->fullname,
                    '',
                    $product->email,
                    $product->address,
                    $product->telp_number
                ),
                new UserId($product->user_id)
            );
        }
        return $products;
    }

    public function byId(ProductId $productId): ?Product
    {

        $query = "SELECT p.*, u.id as userId, u.username as username, u.fullname as fullname,
                u.email as email, u.telp_number as telp_number
                FROM Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p
                JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id = p.user_id
                WHERE p.id=:id:";
        // var_dump( $query);
        // die();

        $productRecord = $this->modelsManager->createQuery($query)->execute([
            'id' => $productId->getId()
        ]);

        if (!empty($productRecord))
            return new Product(
                new ProductId($productRecord[0]->p->id),
                $productRecord[0]->p->product_name,
                $productRecord[0]->p->description,
                $productRecord[0]->p->created_at,
                $productRecord[0]->p->updated_at,
                $productRecord[0]->p->stock,
                $productRecord[0]->p->price,
                $productRecord[0]->p->wishlist_counter,
                null,
                new User(
                    new UserId($productRecord[0]->userId),
                    $productRecord[0]->username,
                    $productRecord[0]->fullname,
                    "",
                    $productRecord[0]->email,
                    "",
                    $productRecord[0]->telp_number
                ),
                new UserId($productRecord[0]->userId)
            );

        return null;
    }

    public function bySellerId(UserId $userId)
    {

        $query = "SELECT p.id, p.product_name, p.description, p.created_at, p.updated_at,
                p.stock, p.price, p.wishlist_counter,
                p.user_id, u.username, u.fullname, u.email, u.address, u.telp_number, u.status_user
                FROM Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p
                JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id = p.user_id
                WHERE u.id=:id:";

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
        $productRecord->image_path = $product->getImagePath();

        if ($productRecord->save()) {
            $transx->commit();

            return true;
        }


        $transx->rollback();
        return new Failed($productRecord->getMessages()[0]);
    }

    public function deleteProduct(ProductId $productId)
    {
       
        $transx = (new Manager())->get();
        
        $product = ProductRecord::findById($productId->getId());
            
        if (isset($product)) {
            if ($product->delete()) {
                $transx->commit();

                return true;
            }
        } else {
            return false;
        }

        $transx->rollback();
        return new Failed($product->getMessages()[0]);
    }

    public function searchProduct(string $keyword)
    {
        $productRecord = ProductRecord::find([
            'conditions' => 'product_name LIKE :keyword:',
            'bind' => [
                'keyword' => '%' . $keyword . '%'
            ]
        ]);

        $products = [];
        foreach ($productRecord as $product) {
            $products[] = new Product(
                new ProductId($product->id),
                $product->product_name,
                $product->description,
                $product->created_at,
                $product->updated_at,
                $product->stock,
                $product->price,
                $product->wishlist_counter,
                $product->image_path,
                new User(
                    new UserId($product->user_id),
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                )
            );
        }

        return $products;
    }

    public function editProduct(array $datas, ProductId $productId)
    {
        
        $productResult = ProductRecord::findFirstById($productId->getId());
        if (isset($productResult)) {
            $trans = (new Manager())->get();
            $productRecord = new ProductRecord();
            $productRecord->id = $productId->getId();
            $productRecord->wishlist_counter = 0;
            $productRecord->created_at = (new \DateTime())->format('Y-m-d H:i:s');
            $productRecord->updated_at = (new \DateTime())->format('Y-m-d H:i:s');
            foreach ($datas as $data => $val) {
                if($val !== null)
                    $productRecord->$data = $val;
            }
            // var_dump($productRecord);
            // die();

            if ($productRecord->update()) {
                $trans->commit();
                return true;
            } else {
                $trans->rollback();

                return new Failed($productRecord->getMessages()[0]);
            }
        }

        return false;
    }
}
