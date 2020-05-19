<?php


namespace Dex\Marketplace\Application\ChangeProfileUser;


class ChangeProfileUserRequest
{
    public ?string $username;
    public ?string $fullname;
    public ?string $status_user;
    public ?string $email;
    public ?string $address;
    public ?string $telp_number;
    public ?string $newPassword;
    public string $userId;

    public function __construct(
        string $userId,
        string $username,
        string $fullname,
        string $status_user,
        string $email,
        string $address,
        string $telp_number,
        string $newPassword
    )
    {
        $this->userId = $userId;
        $this->fullname = $fullname;
        $this->username = $username;
        $this->address = $address;
        $this->telp_number = $telp_number;
        $this->status_user = $status_user;
        $this->email = $email;
        $this->newPassword = $newPassword;
    }

}
