<?php


namespace Dex\Marketplace\Application\TransactionBuyer;


use Dex\Marketplace\Domain\Exception\InvalidIdModelException;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\PaymentMethodTransaction;
use Dex\Marketplace\Domain\Model\Transaction;
use Dex\Marketplace\Domain\Model\TransactionId;
use Dex\Marketplace\Domain\Repository\CartRepository;
use Dex\Marketplace\Domain\Repository\TransactionRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class TransactionBuyerService
{
    private CartRepository $cartRepository;
    private TransactionRepository $transactionRepository;

    public function __construct(CartRepository $cartRepository, TransactionRepository $transactionRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(TransactionBuyerRequest $request): TransactionBuyerResponse
    {
        $cartModel = $this->cartRepository->byId(new CartId($request->cartId));
        $userModel = $cartModel->getBuyer();

        $transactionId = new TransactionId();
        $paymentMethod = new PaymentMethodTransaction(
            $transactionId,
            $request->paymentMethod
        );

        $transactionModel = new Transaction(
            $transactionId,
            $userModel,
            $cartModel,
            $paymentMethod,
            Transaction::$PENDING,
            (new \DateTime())->format('Y-m-d H:i:s'),
            (new \DateTime())->format('Y-m-d H:i:s') // Updated_at == created_at
        );
        $response = $this->transactionRepository->save($transactionModel);
        if ($response instanceof Failed)
            return new TransactionBuyerResponse($response, $response->getMessage(), 500, true);

        //EVENT
        $eventResponse = $transactionModel->notifyPostTransaction();
        if ($eventResponse instanceof InvalidIdModelException){
            return new TransactionBuyerResponse($eventResponse,
                $eventResponse->getMessage(), $eventResponse->getCode(), true);
        }

        return new TransactionBuyerResponse(null, 'Product is waiting to be paid.', 200, false);
    }

}
