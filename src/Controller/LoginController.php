<?php

namespace App\Controller;

use stdClass;
use App\Controller\CustomAbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsController]
class LoginController extends CustomAbstractController
{
    public function checkRequirements(stdClass $data): array
    {
        $userEmail = $data->email ?? throw new HttpException(400, 'missing user email');

        $user = $this->userRepository->findOneByEmail($userEmail) ?? throw new HttpException(401, 'user does not exist');

        $password = $data->password ?? throw new HttpException(400, 'missing user password');

        if (!$this->passwordHasher->isPasswordValid($user, $password)) throw new HttpException(401, 'password is incorrect');

        return [
            'X-AUTH-TOKEN' => $this->tokenManager->createToken($user)
        ];
    }
}
