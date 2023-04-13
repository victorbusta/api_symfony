<?php

namespace App\Controller\CreateController;

use App\Entity\Article;
use App\Entity\Machine;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Controller\CreateController\AbstractCreateController;
use DateTime;
use DateTimeImmutable;

#[AsController]
class CreateMachineController extends AbstractCreateController
{
    public function createEntity($data): Article
    {
        // creating machine
        $machine = new Machine();

        $machine->setBrand($data->brand ?? throw new HttpException(400, 'missing machine brand'));
        $machine->setPriceMax($data?->priceMax);
        $machine->setPriceMin($data?->priceMin);

        // creating article
        $article = new Article();

        $article->setArticleType($this->articleTypeRepository->findByType('Machine'));
        $article->setName($data->name ?? throw new HttpException(400, 'missing machine name'));
        $article->setDescription($data->description ?? throw new HttpException(400, 'missing machine description'));

        // set creation date
        $article->setCreatedAt(new DateTimeImmutable());

        // saving machine
        $this->machineRepository->save($machine, true);

        $article->setUser($this->getUser());
        $article->setMachine($machine);

        // saving article
        $this->articleRepository->save($article, true);

        return $article;
    }
}
