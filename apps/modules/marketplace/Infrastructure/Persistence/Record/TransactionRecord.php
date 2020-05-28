<?php


namespace Dex\Marketplace\Infrastructure\Persistence\Record;


use Phalcon\Mvc\Model;

class TransactionRecord extends Model
{
    private string $id;
    private string $user_id;
    private string $cart_id;
    private string $payment_method;
    private string $status_transaction;
    private string $createdAt;
    private ?string $updatedAt;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSchema('dbo');
        $this->setSource('transaction');

        $this->belongsTo('user_id', UserRecord::class, 'id' , [
            'reusable' => true
        ]);

        $this->belongsTo('cart_id', CartRecord::class, 'id');

    }

}
