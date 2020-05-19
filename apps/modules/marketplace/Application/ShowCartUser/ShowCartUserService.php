<?php


namespace Dex\Marketplace\Application\ShowCartUser;


use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\CartRepository;

class ShowCartUserService
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function execute(ShowCartUserRequest $request): ShowCartUserResponse
    {
        $userId = $request->userId;

        $res = $this->cartRepository->byBuyerId(new UserId($userId));

        if (!isset($res)) {
            return new ShowCartUserResponse(null, 'Not Found', 200, false);
        }

        return new ShowCartUserResponse($res, '', 200, false);
    }

}
