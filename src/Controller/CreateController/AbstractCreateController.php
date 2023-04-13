<?php

namespace App\Controller\CreateController;

use stdClass;
use App\Entity\Article;
use App\Controller\CustomAbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractCreateController extends CustomAbstractController
{
    public function checkRequirements(stdClass $data): array
    {
        return [
            'created' => $this->createEntity($data),
        ];
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    abstract function createEntity(stdClass $data): mixed;
}
