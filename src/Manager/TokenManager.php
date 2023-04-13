<?php

namespace App\Manager;
use App\Entity\User;
use App\Repository\UserRepository;

class TokenManager
{
    public function __construct(
        private UserRepository $userRepository,
    ) 
    {
    }

    public function createToken(User $user): string
    {
        $token['payload'] = [
            'expiration' => time() + $_ENV['JWT_TTL'],
            'user_id' => $user->getId(),
            'user_email' => $user->getEmail(),
        ];

        $token['signature'] = $this->encrypt(json_encode($token['payload']));

        return json_encode($token);
    }

    public function validateToken(string|null $token): string|null
    {
        $token = json_decode($token);

        $user = $this->userRepository->find($token?->payload?->user_id);

        if ($token?->payload === null || $user === null) return null;

        if ($this->encrypt(json_encode($token?->payload)) !== $token?->signature) return null;

        if (time() > (int) $token?->payload?->expiration) return null;

        return $user->getUserIdentifier();
    }

    public function getUser(string $token): User
    {
        $token = json_decode($token);

        return $this->userRepository->find($token->payload->user_id);
    }

    private function encrypt(string $data)
    {
        return openssl_encrypt(
            $data,
            $_ENV['CIPHER_TYPE'],
            $_ENV['JWT_PASSPHRASE'],
            $_ENV['CIPHER_OPTION'],
            $_ENV['ENCRYPTTION_INITVECTOR']
        );
    }
}