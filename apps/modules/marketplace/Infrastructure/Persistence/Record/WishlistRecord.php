<?php


namespace Dex\Marketplace\Infrastructure\Persistence\Record;


use Phalcon\Mvc\Model;

class WishlistRecord extends Model
{
    public string $id;
    public string $product_id;
    public string $user_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSchema('dbo');
        $this->setSource('wishlist');

        $this->hasMany('product_id', ProductRecord::class, 'id');
        $this->belongsTo('user_id', UserRecord::class, 'id');
    }

}
