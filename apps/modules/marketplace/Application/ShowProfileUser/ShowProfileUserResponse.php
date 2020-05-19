<?php


namespace Dex\Marketplace\Application\ShowProfileUser;


use Dex\Marketplace\Application\GenericResponse;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\Wishlist;

class ShowProfileUserResponse extends GenericResponse
{
    public function __construct($data, $message, $code = 200, $error = null)
    {
        if($code == 200)
            parent::__construct($this->parsingData($data), $message, $code, $error);
        else
            parent::__construct(null,  $message, $code, $error);
    }

    private function parsingData(array $datas)
    {
        /**
         * @var User $user
         */
        $user = $datas['user'];

        /**
         * @var Wishlist $wishlist
         */
        $wishlist = $datas['wishlist'];

        $resUser = (object)[
            'id' => $user->getId()->getId(),
            'username' => $user->getUsername(),
            'fullname' => $user->getFullname(),
            'email' => $user->getEmail(),
            'telp_number' => $user->getTelp(),
            'address' => $user->getAddress(),
            'password' => $user->getPassword(),
            'status_user' => $user->getStatusUser()
        ];

        if (empty($wishlist))
            $resWishlist = [];
        else
            $resWishlist = (object)[
                'id' => $wishlist->getId(),
                'product_id' => $wishlist->getProduct()->getId()->getId(),
                'product_name' => $wishlist->getProduct()->getProductName(),
                'price' => $wishlist->getProduct()->getPrice(),
                'stock' => $wishlist->getProduct()->getStock(),
                'description' => $wishlist->getProduct()->getDescription()
            ];

        return array('user' => $resUser, 'wishlist' => $resWishlist);
    }

}
