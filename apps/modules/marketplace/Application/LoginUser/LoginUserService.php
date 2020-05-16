<?php


namespace Dex\Marketplace\Application\LoginUser;


use DateTimeImmutable;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Http\Cookie;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Model\Transaction\Failed;

class LoginUserService extends \Phalcon\Di\Injectable
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $response = $this->userRepository->byUsername($request->username);

        if (!$this->verifyPassword($request->password, $response->getPassword()))
            return new LoginUserResponse(null, "Incorrect Password", 200, true);

        if (is_null($response->getId()))
            return new LoginUserResponse(null, "User Not Found", 200, true);

        if ($request->rememberMe) {
            $tomorrow = (new DateTimeImmutable())->modify('tomorrow');

            $rememberMe = json_encode([
                'user_id' => $response->getId()->getId(),
                'username' => $response->getUsername(),
                'fullname' => $response->getFullname(),
                'password' => $response->getPassword()
            ]);

            $this->cookies->set('rememberMe', $rememberMe, (int) $tomorrow->format('U'));
            $this->cookies->send();
//            $this->response->setCookies($this->cookies);
//            $this->response->sendCookies();
        }

        $this->session->set('username', $response->getUsername());
        $this->session->set('fullname', $response->getFullname());
        $this->session->set('user_id', $response->getId()->getId());

        return new LoginUserResponse($response, "Login Success", 200, false);
    }

    private function verifyPassword($password, $dbPassword): bool
    {
        return password_verify($password, $dbPassword);
    }

}
