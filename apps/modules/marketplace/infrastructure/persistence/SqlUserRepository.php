<?php


namespace Dex\Marketplace\Infrastructure\persistence;


use Dex\Marketplace\Domain\Model\User;
use Dex\marketplace\domain\model\UserId;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Dex\Marketplace\Infrastructure\persistence\Record\UserRecord;
use Phalcon\Db\Adapter\Pdo\Sqlsrv;

class SqlUserRepository implements UserRepository
{

    private function parsingRecord(UserRecord $record): User
    {
        return new User(
            new UserId($record->id),
            $record->username,
            $record->fullname,
            $record->password,
            $record->email,
            $record->address,
            $record->no_telp,
            $record->status_user
        );
    }

    public function byId(UserId $id): ?User
    {
        $userRecord = UserRecord::findFirstById($id->getId());

        return $this->parsingRecord($userRecord);
    }

    public function save(User $user): bool
    {
        return false;
    }

    public function getPassword(User $user): string
    {
        // TODO: Implement getPassword() method.
    }

    public function setStatusUser(User $user, string $status = ""): bool
    {
        if (empty($status)) {
            $status_user = $user->getStatusUser();
        } else {
            $status_user = $status;
        }


    }

    public function changeProfile(User $user, array $data = []): bool
    {
        // TODO: Implement changeProfile() method.
    }
}
