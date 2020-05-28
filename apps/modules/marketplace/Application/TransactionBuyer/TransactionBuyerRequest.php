<?php


namespace Dex\Marketplace\Application\TransactionBuyer;


class TransactionBuyerRequest
{
    public string $cartId;
    public string $userId;
    public string $paymentMethod;

    public function __construct(
        string $cartId,
        string $userId,
        string $paymentMethod
    )
    {
        $this->cartId = $cartId;
        $this->userId = $userId;
        $this->paymentMethod = $paymentMethod;
    }

}
