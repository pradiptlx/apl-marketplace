<?php


namespace Dex\Marketplace\Application\IncrementStockProductCounter;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Event\ChangeProductCounterEvent;
use Dex\Marketplace\Domain\Repository\ProductRepository;

class IncrementStockProductCounterService implements DomainEventSubscriber
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    private array $subscribedTo = [
        ChangeProductCounterEvent::class
    ];

    public function handle($aDomainEvent)
    {
        if($aDomainEvent instanceof ChangeProductCounterEvent){
            $datas = [
                'stock' => $aDomainEvent->incStockCounter()
            ];

            $res = $this->productRepository->editProduct($datas, $aDomainEvent->getProductId());

        }
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
