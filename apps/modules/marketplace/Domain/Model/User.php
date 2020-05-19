<?php


namespace Dex\Marketplace\Domain\Model;


use Dex\Common\Events\DomainEventPublisher;

class User
{
    protected UserId $id;
    protected string $username;
    protected string $fullname;
    protected string $password;
    protected string $email;
    protected string $address;
    protected string $telp_number;
    protected string $status_user;
    protected string $created_at;
    protected string $updated_at;

    public const STATUS_USER = "BUYER";
    public static string $BUYER = 'BUYER';
    public static string $SELLER = 'SELLER';

    public function __construct(
        UserId $id, string $username, string $fullname,
        string $password, string $email, string $address,
        string $telp_number, string $status = self::STATUS_USER
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->email = $email;
        $this->address = $address;
        $this->telp_number = $telp_number;
        $this->status_user = $status;
    }

    // Send mail and others after click buy
    public function processTransaction(Product $product)
    {
        DomainEventPublisher::instance()->publish(
            new Product(
                new ProductId($product->getId()),
                $product->getProductName(),
                $product->getDescription(),
                $product->getCreatedDate(),
                $product->getUpdatedDate(),
                $product->getStock(),
                $product->getPrice(),
                $product->incWishlistCounter(),
                $product->getImagePath(),
                $product->getSeller()
            )
        );
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function getPassword(): string
    {
        return $this->password;
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
        return $this->telp_number;
    }

    public function getStatusUser(): string
    {
        return $this->status_user;
    }

    public function getCreatedDate(): string
    {
        return $this->created_at;
    }

    public function getUpdatedDate(): string
    {
        return $this->updated_at;
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
        $this->telp_number = $telp;
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

    public function isSeller(string $status = null): bool
    {
        if (isset($status))
            return strtoupper($status) === self::$SELLER;
        else
            return strtoupper($this->status_user) === self::$SELLER;
    }
}
