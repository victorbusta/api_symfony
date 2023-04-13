<?php

namespace App\Controller\UpdateController;

use stdClass;
use App\Controller\CustomAbstractController;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstracUpdateController extends CustomAbstractController
{
    public function checkRequirements(stdClass $data): array
    {
        if ($this->checkData($data)) throw new HttpException(400, 'data provided is incorrect');

        return [
            'updated' => $this->updateEntity($data),
        ];
    }

    abstract function checkData($data):bool;

    abstract function updateEntity($data):bool;
}
