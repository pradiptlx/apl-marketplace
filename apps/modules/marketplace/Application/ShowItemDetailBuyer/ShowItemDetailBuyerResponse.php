<?php


namespace Dex\Marketplace\Application\ShowItemDetailBuyer;


use Dex\Marketplace\Application\GenericResponse;

class ShowItemDetailBuyerResponse extends GenericResponse
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
        $resProduct = (object)[
            'id' => $product->getId()->getId(),
            'product_name' => $product->getProductName(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
            'seller_name' => $product->getSeller()->getFullname(),
            'email' => $product->getSeller()->getEmail(),
            'telp' => $product->getSeller()->getTelp()
        ];

        return array('product' => $resProduct);
    }

}
