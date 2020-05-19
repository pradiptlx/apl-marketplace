<?php


namespace Dex\Marketplace\Application\SearchProduct;


class SearchProductRequest
{
    public string $keyword;

    public function __construct(string $keyword)
    {
        $this->keyword = $keyword;
    }

}
