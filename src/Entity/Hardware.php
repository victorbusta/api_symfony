<?php

namespace App\Entity;

abstract class Hardware
{
    private ?int $id = null;


    public function getId(): ?int
    {
        return $this->id;
    }
}
