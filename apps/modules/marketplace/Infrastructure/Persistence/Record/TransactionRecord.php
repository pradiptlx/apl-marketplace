<?php


namespace Dex\Marketplace\Infrastructure\Persistence\Record;


use Phalcon\Mvc\Model;

class TransactionRecord extends Model
{
    public string $id;
    public string $user_id;
    public string $cart_id;
    public string $payment_method;
    public string $status_transaction;
    public string $created_at;
    public ?string $updated_at;

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
