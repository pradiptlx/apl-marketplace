<?php


namespace Dex\Marketplace\Domain\Model;


class User
{
    protected UserId $id;
    protected string $username;
    protected string $fullname;
    protected string $password;
    protected string $email;
    protected string $address;
    protected string $telp_no;
    protected string $status_user;

    public const STATUS_USER = "BUYER";
    public static string $BUYER = 'BUYER';
    public static string $SELLER = 'SELLER';

    public function __construct(
        UserId $id, string $username, string $fullname,
        string $password, string $email, string $address,
        string $telp_no, string $status = self::STATUS_USER
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->email = $email;
        $this->address = $address;
        $this->telp_no = $telp_no;
        $this->status_user = $status;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getTelp(): string
    {
        return $this->telp_no;
    }

    public function getStatusUser(): string
    {
        return $this->status_user;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function setFullname(string $fullname)
    {
        $this->fullname = $fullname;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function setTelp(string $telp)
    {
        $this->telp_no = $telp;
    }

    public function changeStatusUser()
    {
        switch ($this->status_user) {
            case User::$BUYER:
                $this->status_user = User::$SELLER;
                break;
            case User::$SELLER:
                $this->status_user = User::$BUYER;
                break;
            default:
                break;
        }
    }
}
