<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\PaymentMethodTransaction;
use Dex\Marketplace\Domain\Model\Transaction;
use Dex\Marketplace\Domain\Model\TransactionId;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\TransactionRepository;
use Phalcon\Mvc\Model\Resultset;

class SqlTransactionRepository implements TransactionRepository
{

    private function parsingResult(Resultset $result)
    {
        $transactions = [];

        foreach ($result as $transaction) {
            if (!(isset($transaction)))
                return [];

            // TODO: FIX CART relation
            $transactions[] = new Transaction(
                new TransactionId($transaction->id),
                new User(
                    new UserId($transaction->user_id),
                    $transaction->username,
                    $transaction->fullname,
                    '',
                    $transaction->email,
                    '',
                    '',
                    ''
                ),
                null,
                new PaymentMethodTransaction(
                    new TransactionId($transaction->id),
                    $transaction->payment_method
                ),
                $transaction->status_transaction,
                $transaction->created_at,
                $transaction->updated_at
            );
        }

    }

    public function byId(TransactionId $transactionId): ?Transaction
    {
        // TODO: Implement byId() method.
    }

    public function byUserId(UserId $userId)
    {
        // TODO: Implement byUserId() method.
    }

    public function save(Transaction $transaction)
    {
        // TODO: Implement save() method.
    }

    public function delete(TransactionId $transactionId)
    {
        // TODO: Implement delete() method.
    }

    public function update(array $datas, TransactionId $transactionId)
    {
        // TODO: Implement update() method.
    }
}
