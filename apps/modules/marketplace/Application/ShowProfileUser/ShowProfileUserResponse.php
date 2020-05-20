<?php


namespace Dex\Marketplace\Application\ShowProfileUser;


use Dex\Marketplace\Application\GenericResponse;
use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\Wishlist;

class ShowProfileUserResponse extends GenericResponse
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
         * @var User $user
         */
        $user = $datas['user'];
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

        /**
         * @var Wishlist $item
         */
        $wishlist = $datas['wishlist'];
        $resWishlist = [];
        foreach ($wishlist as $item) {
            $resWishlist[] = (object)[
                'id' => $item->getId()->getId(),
                'product_id' => $item->getProduct()->getId()->getId(),
                'product_name' => $item->getProduct()->getProductName(),
                'price' => $item->getProduct()->getPrice(),
                'stock' => $item->getProduct()->getStock(),
                'description' => $item->getProduct()->getDescription()
            ];
        }

        /**
         * @var Cart $item
         */
        $cart = $datas['cart'];
        $cartRes = [];
        foreach ($cart as $item) {
            $cartRes[] = (object)[
                'id' => $item->getId()->getId(),
                'product_id' => $item->getProduct()->getId()->getId(),
                'product_name' => $item->getProduct()->getProductName(),
                'price' => $item->getProduct()->getPrice(),
                'stock' => $item->getProduct()->getStock(),
                'description' => $item->getProduct()->getDescription()
            ];
        }

        return array('user' => $resUser, 'wishlist' => $resWishlist, 'cart' => $cartRes);
    }

}
