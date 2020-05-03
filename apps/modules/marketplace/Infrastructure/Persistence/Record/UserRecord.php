<?php


namespace Dex\Marketplace\Infrastructure\Persistence\Record;


use Phalcon\Mvc\Model;

class UserRecord extends Model
{

    public string $id;
    public string $username;
    public string $fullname;
    public string $password;
    public string $email;
    public string $address;
    public string $no_telp;
    public string $status_user;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('user');

    }

}
