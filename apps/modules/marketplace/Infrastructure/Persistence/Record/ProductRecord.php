<?php


namespace Dex\Marketplace\Infrastructure\Persistence\Record;


use Phalcon\Mvc\Model;

class ProductRecord extends Model
{
    public string $id;
    public string $product_name;
    public string $description;
    public string $created_at;
    public ?string $updated_at;
    public int $stock;
    public string $price;
    public ?int $wishlist_counter;
    public string $user_id;

    public function initialize(){
        $this->setConnectionService('db');
        $this->setSource('product');

        $this->belongsTo('user_id', UserRecord::class, 'id');
    }
}