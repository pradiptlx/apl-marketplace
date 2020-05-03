<?php


namespace Dex\Marketplace\Application;


use Dex\Marketplace\Domain\Exception\InvalidUsernameDomainException;
use Dex\Marketplace\Domain\Model\User;
use Dex\marketplace\domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\UserRepository;

class CreateUserAccountService
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CreateUserAccountRequest $userAccountRequest): CreateUserAccountResponse
    {
        try {
            $userModel = new User(
                new UserId(),
                $userAccountRequest->getUsername(),
                $userAccountRequest->getFullname(),
                $userAccountRequest->getPassword(),
                $userAccountRequest->getEmail(),
                $userAccountRequest->getAddress(),
                $userAccountRequest->getTelp(),
                $userAccountRequest->getStatusUser()
            );

            $response = $this->userRepository->save($userModel);

            if ($response instanceof InvalidUsernameDomainException)
                throw new InvalidUsernameDomainException($response->getMessage());
            elseif ($response instanceof \Exception)
                throw new \Exception($response->getMessage());

            return new CreateUserAccountResponse($response, "User created successfully");

        } catch (InvalidUsernameDomainException $exception) {
            return new CreateUserAccountResponse($exception, $exception->getMessage(), 400, true);
        } catch (\Exception $exception) {
            return new CreateUserAccountResponse($exception, $exception->getMessage(), 500, true);
        }
    }

}
