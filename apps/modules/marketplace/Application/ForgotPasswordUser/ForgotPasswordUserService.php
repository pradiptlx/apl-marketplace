<?php


namespace Dex\Marketplace\Application\ForgotPasswordUser;


use Dex\Marketplace\Domain\Repository\UserRepository;

class ForgotPasswordUserService extends \Phalcon\Di\Injectable
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ForgotPasswordUserRequest $request): ForgotPasswordUserResponse
    {
        $email = $request->getEmail();
        $user = $this->userRepository->byEmail($email);
        $response = $this->userRepository->isEmailAlreadyExist($email);

        if (!$response) {
            return new ForgotPasswordUserResponse($response, 'Email not found', 400, true);
        }

        try {
            // Generate token using hash, not enc
            $token = password_hash('reset ' . $email, PASSWORD_BCRYPT);
        } catch (\Exception $e) {
            return new ForgotPasswordUserResponse($e, $e->getMessage(), 500, true);
        }

        $mailerService = SendForgotPasswordNotificationService::createMailerService(
            $this->di->get('swiftMailer'));

        $response = $mailerService->handle($user, 'dex@mailtrap.io', $token);


        return new ForgotPasswordUserResponse($response, 'Check your email', 200, false);
    }

}
