<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Exception\InvalidEmailDomainException;
use Dex\Marketplace\Domain\Exception\InvalidUsernameDomainException;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Dex\Marketplace\Infrastructure\Persistence\Record\UserRecord;
use Phalcon\Db\Adapter\Pdo\Sqlsrv;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

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

    public function isUsernameAlreadyExist(string $username): bool
    {
        $user = UserRecord::findFirstByUsername($username);

        if (is_null($user->username)) {
            return false;
        }
        return true;
    }

    public function isEmailAlreadyExist(string $email): bool
    {
        $user = UserRecord::findFirstByEmail($email);

        if (is_null($user->email)) {
            return false;
        }
        return true;
    }

    public function byId(UserId $id): ?User
    {
        $userRecord = UserRecord::findFirstById($id->getId());

        return $this->parsingRecord($userRecord);
    }

    public function byEmail(string $email): ?User
    {
        $userRecord = UserRecord::findFirstByEmail($email);

        return $this->parsingRecord($userRecord);
    }

    public function save(User $user)
    {
        if ($this->isUsernameAlreadyExist($user->getUsername()))
            return new InvalidUsernameDomainException(
                'Username already taken');
        if($this->isEmailAlreadyExist($user->getEmail()))
            return new InvalidEmailDomainException(
                'Email already registered');

        $trans = (new Manager())->get();

        try {
            $userModel = new UserRecord();
            $userModel->id = $user->getId()->getId();
            $userModel->username = $user->getUsername();
            $userModel->fullname = $user->getFullname();
            $userModel->password = $user->getPassword();
            $userModel->email = $user->getEmail();
            $userModel->address = $user->getAddress();
            $userModel->no_telp = $user->getTelp();
            $userModel->status_user = $user->getStatusUser();
            $userModel->created_at = (new \DateTime())->format('Y-m-d H:i:s');
            $userModel->updated_at = (new \DateTime())->format('Y-m-d H:i:s');

            if ($userModel->save()) {
                $trans->commit();

                // Do something
                return $user;
            } else {
                $trans->rollback();

                throw new Failed('Failed save new user');
            }
        } catch (Failed $exception) {
            return new \Exception('Error');
        }

    }

    public function getPassword(User $user): string
    {
        $userModel = UserRecord::findFirst([
            'conditions' => 'id=:id:',
            'bind' => [
                'id' => $user->getId()->getId()
            ]
        ]);

        return $userModel->password;

    }

    public function setStatusUser(User $user, string $status = null)
    {
        if (isset($status)) {
            $status_user = $status;
        } else {
            $status_user = $user->getStatusUser();
        }

        $trans = (new Manager())->get();

        try {
            $userModel = new UserRecord();
            $userModel->status_user = $status_user;

            if ($userModel->update()) {
                $trans->commit();

                return true;
            }
            throw new Failed("Can't update status user");
        } catch (Failed $exception) {
            //TODO: Exception
        }

    }

    public function changeProfile(User $user, array $datas = [])
    {
        $trans = (new Manager())->get();

        $userModel = new UserRecord();
        foreach ($datas as $data => $val){
            $userModel->$data = $val;
        }

        if($userModel->update()){
            $trans->commit();

            return true;
        }
        $trans->rollback();
        return new Failed((string)$trans->getMessages());
    }

}
