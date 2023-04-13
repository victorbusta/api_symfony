<?php

namespace App\Controller;

use stdClass;
use App\Entity\User;
use App\Controller\CustomAbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsController]
class RegisterController extends CustomAbstractController
{
    public function checkRequirements (stdClass $data): array
    {
        $email = $data->email ?? throw new HttpException(400, 'missing user email');

        $username = $data->username ?? throw new HttpException(400, 'missing user username');

        $password = $data->password ?? throw new HttpException(400, 'missing user password');

        if ($this->userRepository->findOneByEmail($email) !== null) throw new HttpException(401, 'user already exist');

        $user = $this->createUser(
            email: $email,
            username: $username,
            password: $password
        );

            // generate a signed url and email it to the user
            // $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            //     (new TemplatedEmail())
            //         ->from(new Address('muzikaloid.tech@gmail.com', 'admin_blog'))
            //         ->to($user->getEmail())
            //         ->subject('Please Confirm your Email')
            //         ->htmlTemplate('registration/confirmation_email.html.twig')
            // );
            // do anything else you need here, like send an email

        return [
            'X-AUTH-TOKEN' => $this->tokenManager->createToken($user)
        ];
    }

    // #[Route('/verify/email', name: 'app_verify_email')]
    // public function verifyUserEmail(Request $request): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //     // validate email confirmation link, sets User::isVerified=true and persists
    //     try {
    //         $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    //     } catch (VerifyEmailExceptionInterface $exception) {
    //         $this->addFlash('verify_email_error', $exception->getReason());

    //         return $this->redirectToRoute('app_register');
    //     }

    //     // @TODO Change the redirect on success and handle or remove the flash message in your templates
    //     $this->addFlash('success', 'Your email address has been verified.');

    //     return $this->redirectToRoute('app_acceuil');
    // }

    private function createUser(string $email, string $username, string $password): User
    {
        $user = new User();

        $user->setEmail($email);
        $user->setUsername($username);

        // hash the plain password
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $password
            )
        );

        $user->setRoles([
            'ROLE' => 'ROLE_USER',
            'exp' => 1,
        ]);

        $this->userRepository->save($user, true);

        return $user;
    }
}
