<?php


namespace Dex\Marketplace\Application\EditProduct;


use Dex\Marketplace\Application\GenericResponse;

class EditProductResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        parent::__construct($data, $message, $code, $error);
    }

}
