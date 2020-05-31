<?php


namespace Dex\Marketplace\Application\ListItemsBuyer;


use Dex\Marketplace\Application\GenericResponse;
use Dex\Marketplace\Domain\Model\Product;

class ListItemsBuyerResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        if ($code == 200)
            parent::__construct($this->parsingData($data), $message, $code, $error);
        else
            parent::__construct(null, $message, $code, $error);
    }

    private function parsingData(array $datas)
    {
        /**
         * @var Product $product
         */
        $product = $datas['product'];
        $resProduct = [];
        foreach ($product as $item) {
            $resProduct[] = (object)[
                'id' => $item->getId()->getId(),
                'product_name' => $item->getProductName(),
                'price' => $item->getProduct()->getPrice(),
                'description' => $item->getProduct()->getDescription()
            ];
        }

     

        return array('product' => $resProduct);
    }

}
