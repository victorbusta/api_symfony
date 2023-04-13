<?php

namespace App\Controller;

use stdClass;
use App\Entity\User;
use App\Entity\Article;
use App\Manager\TokenManager;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\MachineRepository;
use App\Repository\DocumentRepository;
use App\Repository\ComponentRepository;
use App\Repository\ArticleTypeRepository;
use App\Repository\DocumentTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


abstract class CustomAbstractController extends AbstractController
{
    protected Request $request;
    protected Serializer $serializer;

    public function __construct (
        public TokenManager $tokenManager,
        public UserPasswordHasherInterface $passwordHasher,
        public UserRepository $userRepository,
        public ArticleRepository $articleRepository,
        public ArticleTypeRepository $articleTypeRepository,
        public CommentRepository $commentRepository,
        public MachineRepository $machineRepository,
        public ComponentRepository $componentRepository,
        public DocumentRepository $documentRepository,
        public DocumentTypeRepository $documentTypeRepository,
    )
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent()) ?? throw new HttpException(400, 'no data provided');
        $this->request = $request;

        return $this->json([
            'request' => true,
            'data' => $this->checkRequirements($data),
        ]);
    }

    public function getUser(): User
    {
        return $this->tokenManager->getUser($this->request->headers->get('X-AUTH-TOKEN'));
    }

    public function authUser(Article $article): User
    {
        $user = $this->getUser();

        return $user === $article->getUser() ? $user : throw new HttpException(401, 'not authorized !');
    }


    abstract function checkRequirements (stdClass $data): array;
}
