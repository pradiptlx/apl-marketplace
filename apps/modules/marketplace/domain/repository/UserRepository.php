<?php


namespace Dex\Marketplace\Domain\Repository;


use Dex\Marketplace\Domain\Model\User;
use Dex\marketplace\domain\model\UserId;

interface UserRepository
{
    public function byId(UserId $id): ?User;

    public function save(User $user);

    public function getPassword(User $user): string;

    public function setStatusUser(User $user, string $status = ""): bool;

    public function changeProfile(User $user, array $data = []): bool;

}
