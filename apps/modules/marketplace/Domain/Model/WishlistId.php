<?php


namespace Dex\Marketplace\Domain\Model;


use Dex\Marketplace\Domain\Exception\InvalidIdModelException;
use Ramsey\Uuid\Uuid;

class WishlistId
{
    private ?string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
