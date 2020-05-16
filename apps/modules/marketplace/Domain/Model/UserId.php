<?php


namespace Dex\Marketplace\Domain\Model;


use Ramsey\Uuid\Uuid;

class UserId
{
    private string $id;

    public function __construct(string $id = "")
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    public function getId() : string
    {
        return $this->id;
    }

}
