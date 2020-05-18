<?php


namespace Dex\Marketplace\Application\ForgotPasswordUser;


use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class ForgotPasswordUserService extends \Phalcon\Di\Injectable
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ForgotPasswordUserRequest $request): ForgotPasswordUserResponse
    {
        if($request->isVerify){
            $res = $this->verifyToken($request->token, $this->session->get('email'));
            if($res){

                return new ForgotPasswordUserResponse($res, "OK", 200, false);
            }
            return new ForgotPasswordUserResponse($res, "Token doesn't match", 200, true);
        }elseif ($request->isReset){
            if(!isset($request->password))
                return new ForgotPasswordUserResponse(null, "Error Get Password", 401, true);
            $user = $this->userRepository->byEmail($request->getEmail());

            $datas = [
                'id'=>$user->getId()->getId(),
                'username' =>$user->getUsername(),
                'fullname' => $user->getFullname(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress(),
                'telp_number' => $user->getTelp(),
                'status_user' => $user->getStatusUser(),
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'password' => password_hash($request->password, PASSWORD_BCRYPT)
            ];
            $res = $this->userRepository->changeProfile($user, $datas);

            if($res instanceof Failed)
                return new ForgotPasswordUserResponse($res, $res->getMessage(), 401, true);
            return new ForgotPasswordUserResponse(null, "Reset Password Success", 200, false);
        }

        $email = $request->getEmail();
        $this->session->set('email', $email);
        $user = $this->userRepository->byEmail($email);
        $response = $this->userRepository->isEmailAlreadyExist($email);

        if (!$response) {
            return new ForgotPasswordUserResponse($response, 'Email not found', 400, true);
        }

        try {
            // Generate token using hash, not enc
            $token = openssl_encrypt('reset ' . $email, 'AES-128-ECB', 'mysecretkey1234');
        } catch (\Exception $e) {
            return new ForgotPasswordUserResponse($e, $e->getMessage(), 500, true);
        }

        $mailerService = SendForgotPasswordNotificationService::createMailerService(
            $this->di->get('swiftMailer'));

        $response = $mailerService->handle($user, 'support@dex.test', $token);


        return new ForgotPasswordUserResponse($response, 'Check your email', 200, false);
    }

    private function verifyToken($token, $realEmail){
        $decrypt = openssl_decrypt($token, "AES-128-ECB", "mysecretkey1234");
        $email = explode(" ", $decrypt)[1];

        if($realEmail == $email){
            return true;
        }

        return false;
    }

}
