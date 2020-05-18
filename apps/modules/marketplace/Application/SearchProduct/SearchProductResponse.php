<?php


namespace Dex\Marketplace\Application\SearchProduct;


use Dex\Marketplace\Application\GenericResponse;
use Dex\Marketplace\Domain\Model\Product;

class SearchProductResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($this->parsingJson($data), $message, $code, $error);
    }

    private function parsingJson($datas)
    {
        $json_res['results'] = [];
        /**
         * @var Product $data
         */
        foreach ($datas as $data) {
            $tmp_json[] = [
                'id' => $data->getId()->getId(),
                'text' => $data->getProductName()
            ];
            $json_res['results'] += $tmp_json;
        }

        return $json_res;
    }

}
