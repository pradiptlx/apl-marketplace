<?php


namespace Dex\Marketplace\Application\ShowProfileUser;


use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\CartRepository;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Dex\Marketplace\Domain\Repository\WishlistRepository;

class ShowProfileUserService extends \Phalcon\Di\Injectable
{
    private UserRepository $userRepository;
    private WishlistRepository $wishlistRepository;
    private CartRepository $cartRepository;

    public function __construct(UserRepository $userRepository, WishlistRepository $wishlistRepository,
                                CartRepository $cartRepository)
    {
        $this->userRepository = $userRepository;
        $this->wishlistRepository = $wishlistRepository;
        $this->cartRepository = $cartRepository;
    }

    public function execute(): ShowProfileUserResponse
    {
        $userId = $this->session->get('user_id');
        if (!isset($userId))
            return new ShowProfileUserResponse(null, "Login First", 403, true);

        $user = $this->userRepository->byId(new UserId($userId));

        if (empty($user))
            return new ShowProfileUserResponse(null, "DB Error", 500, true);

        $wishlist = $this->wishlistRepository->byUserId(new UserId($userId));
        $cart = $this->cartRepository->byBuyerId(new UserId($userId));

        $datas = array('user' => $user, 'wishlist' => $wishlist, 'cart'=> $cart);

        return new ShowProfileUserResponse($datas, '', 200, false);
    }

}
