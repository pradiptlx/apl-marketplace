<?php


namespace Dex\Marketplace\Application\IncrementProductCounter;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class IncrementProductCounterService implements DomainEventSubscriber
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    protected array $subscribedTo = [
        Product::class
    ];

    /**
     * @inheritDoc
     */
    public function handle($aDomainEvent): IncrementProductCounterResponse
    {
        if ($aDomainEvent instanceof Product) {
            $datas = [
                'id' => $aDomainEvent->getId()->getId(),
                'wishlist_counter' => $aDomainEvent->getWishlistCounter()
            ];
            $res = $this->productRepository->editProduct($datas, $aDomainEvent->getId());
            if ($res instanceof Failed) {
                return new IncrementProductCounterResponse($res, $res->getMessage(), 500, true);
            }

            if (!$res)
                return new IncrementProductCounterResponse(null, 'Product Not Found', 200, true);

            return new IncrementProductCounterResponse($res, 'Success Add Wishlist', 200, false);
        }

        return new IncrementProductCounterResponse(null, "Domain Exception.", 500, true);
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
