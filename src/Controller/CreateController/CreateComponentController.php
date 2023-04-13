<?php

namespace App\Controller\CreateController;

use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Component;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Controller\CreateController\AbstractCreateController;

#[AsController]
class CreateComponentController extends AbstractCreateController
{
    public function createEntity($data): Article
    {
        // creating componene
        $component = new Component();

        $component->setBrand($data->brand ?? throw new HttpException(400, 'missing component brand'));

        // creating article
        $article = new Article();

        $article->setArticleType($this->articleTypeRepository->findByType('component'));
        $article->setName($data->name ?? throw new HttpException(400, 'missing component name'));
        $article->setDescription($data->description ?? throw new HttpException(400, 'missing component description'));
        $article->setCreatedAt(new DateTimeImmutable());

        // saving component
        $this->componentRepository->save($component, true);

        // adding relations
        $article->setUser($this->getUser());
        $article->setcomponent($component);

        // saving article
        $this->articleRepository->save($article, true);

        return $article;
    }
}
