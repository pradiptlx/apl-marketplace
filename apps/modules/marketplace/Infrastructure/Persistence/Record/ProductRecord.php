<?php


namespace Dex\Marketplace\Infrastructure\Persistence\Record;


use Phalcon\Mvc\Model;

class ProductRecord extends Model
{
    public string $id;
    public string $product_name;
    public string $description;
    public ?string $created_at;
    public ?string $updated_at;
    public int $stock;
    public string $price;
    public ?int $wishlist_counter;
    public string $user_id;
    public ?string $image_path;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSchema('dbo');
        $this->setSource('product');

        $this->hasManyToMany('id', CartRecord::class, 'product_id', 'user_id', UserRecord::class, 'id');
        $this->hasManyToMany('id', WishlistRecord::class, 'product_id', 'user_id', UserRecord::class, 'id');
//        $this->hasMany('id', WishlistRecord::class, 'product_id');
//        $this->hasMany('id', CartRecord::class, 'product_id');
    }
}
