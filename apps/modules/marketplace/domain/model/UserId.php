<?php


namespace Dex\marketplace\domain\model;


use Ramsey\Uuid\Uuid;

class UserId
{
    private string $id;

    public function __construct(string $id = "")
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    public function getId()
    {
        return $this->id;
    }

}
