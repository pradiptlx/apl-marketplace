<?php


namespace Dex\Marketplace\Domain\Repository;


use Dex\Marketplace\Domain\Model\User;
use Dex\marketplace\domain\Model\UserId;

interface UserRepository
{
    public function byId(UserId $id): ?User;

    public function save(User $user);

    public function getPassword(User $user): string;

    public function isUsernameAlreadyExist(string $username): bool;

    public function isEmailAlreadyExist(string $email): bool;

    public function byEmail(string $email): ?User;

    public function setStatusUser(User $user, string $status = "");

    public function changeProfile(User $user, array $data = []);

}
