<?php


namespace Dex\Marketplace\Application\IncrementWishlistProductCounter;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Event\IncreaseProductCounterEvent;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class IncrementWishlistProductCounterService implements DomainEventSubscriber
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    protected array $subscribedTo = [
        IncreaseProductCounterEvent::class
    ];

    /**
     * @inheritDoc
     */
    public function handle($aDomainEvent): IncrementWishlistProductCounterResponse
    {
        if ($aDomainEvent instanceof IncreaseProductCounterEvent) {
            $datas = [
                'wishlist_counter' => $aDomainEvent->incWishlistCounter(),
            ];
            $res = $this->productRepository->editProduct($datas, $aDomainEvent->getProductId());
            if ($res instanceof Failed) {
                return new IncrementWishlistProductCounterResponse($res, $res->getMessage(), 500, true);
            }

            if (!$res)
                return new IncrementWishlistProductCounterResponse(null, 'Product Not Found', 200, true);

            return new IncrementWishlistProductCounterResponse($res, 'Success Add Wishlist', 200, false);
        }

        return new IncrementWishlistProductCounterResponse(null, "Domain Exceptions.", 500, true);
    }

    /**
     * @inheritDoc
     */
    public function isSubscribedTo($aDomainEvent)
    {
        foreach ($this->subscribedTo as $subscribed) {
            if ($aDomainEvent instanceof $subscribed)
                return true;
        }
        return false;
    }
}
