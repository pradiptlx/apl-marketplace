<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\PaymentMethodTransaction;
use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\Transaction;
use Dex\Marketplace\Domain\Model\TransactionId;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\TransactionRepository;
use Dex\Marketplace\Infrastructure\Persistence\Record\TransactionRecord;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

class SqlTransactionRepository extends \Phalcon\Di\Injectable implements TransactionRepository
{

    private function parsingResult(Resultset $result)
    {
        $transactions = [];

        foreach ($result as $transaction) {
            $cart = null;
            if (!(isset($transaction)))
                return [];
            if (isset($transaction->cart_id))
                $cart = new Cart(
                    new CartId($transaction->cart_id),
                    new Product(
                        new ProductId($transaction->product_id),
                        $transaction->product_name,
                        $transaction->product_description,
                        '',
                        '',
                        $transaction->stock,
                        $transaction->price,
                        $transaction->wishlist_counter,
                        $transaction->cart_counter,
                        null,
                        null,
                        null
                    ),
                    new User(
                        new UserId($transaction->user_id),
                        $transaction->username,
                        $transaction->fullname,
                        '',
                        $transaction->email,
                        $transaction->address,
                        $transaction->telp_number,
                        ''
                    ),
                    $transaction->created_at
                );

            $transactions[] = new Transaction(
                new TransactionId($transaction->id),
                new User(
                    new UserId($transaction->user_id),
                    $transaction->username,
                    $transaction->fullname,
                    '',
                    $transaction->email,
                    $transaction->address,
                    $transaction->telp_number,
                    ''
                ),
                $cart,
                new PaymentMethodTransaction(
                    new TransactionId($transaction->id),
                    $transaction->payment_method
                ),
                $transaction->status_transaction,
                $transaction->created_at,
                $transaction->updated_at
            );
        }

        return [];
    }

    public function byId(TransactionId $transactionId)
    {
        $sql = "SELECT t.*, u.username, u.fullname, u.address, u.telp_number, u.email,
               c.product_id,
               p.product_name, p.description, p.stock, p.wishlist_counter, p.cart_counter
               FROM Dex\Marketplace\Infrastructure\Persistence\Record\TransactionRecord t
               JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id=t.user_id
               JOIN Dex\Marketplace\Infrastructure\Persistence\Record\CartRecord c on c.id=t.cart_id
               JOIN Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p on p.id=c.product_id
               WHERE t.id=:id:";

        $transactionResult = $this->modelsManager->createQuery($sql)
            ->execute([
                'id' => $transactionId->getId()
            ]);

        return $this->parsingResult($transactionResult);
    }

    public function byUserId(UserId $userId)
    {
        $sql = "SELECT t.*, u.username, u.fullname, u.address, u.telp_number, u.email,
               c.product_id,
               p.product_name, p.description, p.stock, p.wishlist_counter, p.cart_counter
               FROM Dex\Marketplace\Infrastructure\Persistence\Record\TransactionRecord t
               JOIN Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord u on u.id=t.user_id
               JOIN Dex\Marketplace\Infrastructure\Persistence\Record\CartRecord c on c.id=t.cart_id
               JOIN Dex\Marketplace\Infrastructure\Persistence\Record\ProductRecord p on p.id=c.product_id
               WHERE t.user_id=:user_id:";

        $transactionResult = $this->modelsManager->createQuery($sql)
            ->execute([
                'user_id' => $userId->getId()
            ]);

        return $this->parsingResult($transactionResult);
    }

    public function save(Transaction $transaction)
    {
        $transx = (new Manager())->get();
        $transactionRecord = new TransactionRecord();
        $transactionRecord->id = $transaction->getId()->getId();
        $transactionRecord->user_id = $transaction->getBuyer()->getId()->getId();
        $transactionRecord->cart_id = $transaction->getCart()->getId()->getId();
        $transactionRecord->payment_method = $transaction->getPaymentMethod()->getMethod();
        $transactionRecord->status_transaction = $transaction->getStatusTransaction();
        $transactionRecord->created_at = $transaction->getCreatedDate();
        $transactionRecord->updated_at = $transaction->getUpdatedDate();

        if ($transactionRecord->save()) {
            $transx->commit();
            return true;
        }

        $transx->rollback();
        return new Failed($transactionRecord->getMessages()[0]);
    }

    public function delete(TransactionId $transactionId)
    {
        $transx = (new Manager())->get();
        /**
         * @var TransactionRecord $transactionResult
         */
        $transactionResult = TransactionRecord::findFirstById($transactionId->getId());
        if (isset($transactionResult)) {
            if ($transactionResult->delete()) {
                $transx->commit();
                return true;
            } else {
                $transx->rollback();
                return new Failed($transactionResult->getMessages()[0]);
            }
        }

        return false;
    }

    public function update(array $datas, TransactionId $transactionId)
    {
        /**
         * @var TransactionRecord $transactionResult
         */
        $transactionResult = TransactionRecord::findFirstById($transactionId->getId());
        if (isset($transactionResult)) {
            $trans = (new Manager())->get();
            foreach ($datas as $data => $val) {
                if ($val !== null)
                    $transactionResult->$data = $val;
            }

            if ($transactionResult->update()) {
                $trans->commit();
                return true;
            } else {
                $trans->rollback();

                return new Failed($transactionResult->getMessages()[0]);
            }
        }

        return false;
    }
}
