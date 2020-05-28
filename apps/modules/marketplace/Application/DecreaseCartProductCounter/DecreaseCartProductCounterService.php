<?php


namespace Dex\Marketplace\Application\DecreaseCartProductCounter;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Event\DecreaseProductCounterEvent;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class DecreaseCartProductCounterService implements DomainEventSubscriber
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    protected array $subscribedTo = [
        DecreaseProductCounterEvent::class
    ];

    public function handle($aDomainEvent): DecreaseCartProductCounterResponse
    {
        if ($aDomainEvent instanceof DecreaseProductCounterEvent) {
            $datas = [
                'cart_counter' => $aDomainEvent->decCartCounter(),
            ];
            $res = $this->productRepository->editProduct($datas, $aDomainEvent->getProductId());
            if ($res instanceof Failed) {
                return new DecreaseCartProductCounterResponse($res, $res->getMessage(), 500, true);
            }

            if (!$res)
                return new DecreaseCartProductCounterResponse(null, 'Product Not Found', 200, true);

            return new DecreaseCartProductCounterResponse($res, 'Success Remove Wishlist', 200, false);
        }

        return new DecreaseCartProductCounterResponse(null, 'Domain Exception', 500, true);
    }

    public function isSubscribedTo($aDomainEvent)
    {
        foreach ($this->subscribedTo as $subscribed) {
            if ($aDomainEvent instanceof $subscribed)
                return true;
        }
        return false;
    }
}
