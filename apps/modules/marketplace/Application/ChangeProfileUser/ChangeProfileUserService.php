<?php


namespace Dex\Marketplace\Application\ChangeProfileUser;


use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class ChangeProfileUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ChangeProfileUserRequest $request): ChangeProfileUserResponse
    {
        $datas = [
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'address' => $request->address,
            'telp_number' => $request->telp_number,
            'status_user' => $request->status_user,
            'password' => $request->newPassword
        ];
        $res = $this->userRepository->changeProfile(new UserId($request->userId), $datas);

        if ($res instanceof Failed)
            return new ChangeProfileUserResponse($res, $res->getMessage(), 500, true);

        return new ChangeProfileUserResponse(null, "Profile Changed", 200, false);
    }

}
