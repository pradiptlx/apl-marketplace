<?php


namespace Dex\Marketplace\Application\DecreaseWishlistProductCounter;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Event\DecreaseProductCounterEvent;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class DecreaseWishlistProductCounterService implements DomainEventSubscriber
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    protected array $subscribedTo = [
        DecreaseProductCounterEvent::class
    ];

    public function handle($aDomainEvent): DecreaseWishlistProductCounterResponse
    {
        if ($aDomainEvent instanceof DecreaseProductCounterEvent) {
            $datas = [
                'wishlist_counter' => $aDomainEvent->decWishlistCounter(),
            ];
            $res = $this->productRepository->editProduct($datas, $aDomainEvent->getProductId());
            if ($res instanceof Failed) {
                return new DecreaseWishlistProductCounterResponse($res, $res->getMessage(), 500, true);
            }

            if (!$res)
                return new DecreaseWishlistProductCounterResponse(null, 'Product Not Found', 200, true);

            return new DecreaseWishlistProductCounterResponse($res, 'Success Remove Wishlist', 200, false);
        }

        return new DecreaseWishlistProductCounterResponse(null, 'Domain Exception', 500, true);
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
