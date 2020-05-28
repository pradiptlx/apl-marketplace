<?php


namespace Dex\Marketplace\Domain\Repository;


use Dex\Marketplace\Domain\Model\Transaction;
use Dex\Marketplace\Domain\Model\TransactionId;
use Dex\Marketplace\Domain\Model\UserId;

interface TransactionRepository
{
    public function byId(TransactionId $transactionId);

    public function byUserId(UserId $userId);

    public function save(Transaction $transaction);

    public function delete(TransactionId $transactionId);

    public function update(array $datas, TransactionId $transactionId);

}
