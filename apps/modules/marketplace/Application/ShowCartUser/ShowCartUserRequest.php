<?php


namespace Dex\Marketplace\Application\ShowCartUser;


class ShowCartUserRequest
{
    public string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

}
