<?php


namespace Dex\Marketplace\Application\IncrementCartProductCounter;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Event\IncreaseProductCounterEvent;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class IncrementCartProductCounterService implements DomainEventSubscriber
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
    public function handle($aDomainEvent): IncrementCartProductCounterResponse
    {
        if ($aDomainEvent instanceof IncreaseProductCounterEvent) {
            $datas = [
                'cart_counter' => $aDomainEvent->incCartCounter(),
            ];
            $res = $this->productRepository->editProduct($datas, $aDomainEvent->getProductId());
            if ($res instanceof Failed) {
                return new IncrementCartProductCounterResponse($res, $res->getMessage(), 500, true);
            }

            if (!$res)
                return new IncrementCartProductCounterResponse(null, 'Product Not Found', 200, true);

            return new IncrementCartProductCounterResponse($res, 'Success Add Wishlist', 200, false);
        }

        return new IncrementCartProductCounterResponse(null, "Domain Exceptions.", 500, true);
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