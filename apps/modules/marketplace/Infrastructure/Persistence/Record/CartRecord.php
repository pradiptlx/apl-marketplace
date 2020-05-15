<?php


namespace Dex\Marketplace\Infrastructure\Persistence\Record;


use Phalcon\Mvc\Model;

class CartRecord extends Model
{
    public string $id;
    public string $product_id;
    public string $user_id;
    public string $created_at;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('cart');

        $this->belongsTo('product_id', ProductRecord::class, 'id');
        $this->belongsTo('user_id', UserRecord::class, 'id');
    }

}