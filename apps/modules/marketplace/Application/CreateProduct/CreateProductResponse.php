<?php


namespace Dex\Marketplace\Application\CreateProduct;


use Dex\Marketplace\Application\GenericResponse;

class CreateProductResponse extends GenericResponse
{

    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }


}
