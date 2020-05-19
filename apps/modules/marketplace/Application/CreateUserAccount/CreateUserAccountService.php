<?php


namespace Dex\Marketplace\Application\CreateUserAccount;


use Dex\Marketplace\Domain\Exception\InvalidEmailDomainException;
use Dex\Marketplace\Domain\Exception\InvalidUsernameDomainException;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class CreateUserAccountService extends \Phalcon\Di\Injectable
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CreateUserAccountRequest $userAccountRequest): CreateUserAccountResponse
    {

        if (!$userAccountRequest->getStatusUser() == User::$SELLER
            || !$userAccountRequest->getStatusUser() == User::$BUYER)
            return new CreateUserAccountResponse(null, 'User Type Not Found', 403, true);

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
            elseif ($response instanceof InvalidEmailDomainException)
                throw new InvalidEmailDomainException($response->getMessage());
            elseif ($response instanceof \Exception)
                throw new \Exception($response->getMessage());
            elseif ($response instanceof Failed)
                throw new \Exception($response->getMessage());

            $this->session->set('user_id', $userModel->getId());
            $this->session->set('username', $userModel->getUsername());
            $this->session->set('fullname', $userModel->getFullname());
            $this->session->set('status_user', $userModel->getStatusUser());
            return new CreateUserAccountResponse($response, "User created successfully");

        } catch (InvalidUsernameDomainException $exception) {
            return new CreateUserAccountResponse($exception, $exception->getMessage(), 400, true);
        } catch (InvalidEmailDomainException $exception) {
            return new CreateUserAccountResponse($exception, $exception->getMessage(), 400, true);
        } catch (\Exception $exception) {
            return new CreateUserAccountResponse($exception, $exception->getMessage(), 500, true);
        }
    }

}
