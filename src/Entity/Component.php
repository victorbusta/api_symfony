<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ComponentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ComponentRepository::class)]
class Component extends Hardware
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read'])]
    private ?string $brand = null;

    #[ORM\ManyToMany(targetEntity: Machine::class, mappedBy: 'components')]
    #[Groups(['article:read'])]
    private Collection $machines;

    #[ORM\OneToOne(mappedBy: 'component', cascade: ['persist', 'remove'])]
    #[Groups(['machine:read'])]
    private ?Article $article = null;

    public function __construct()
    {
        $this->machines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, Machine>
     */
    public function getMachines(): Collection
    {
        return $this->machines;
    }

    public function addMachine(Machine $machine): self
    {
        if (!$this->machines->contains($machine)) {
            $this->machines->add($machine);
            $machine->addComponent($this);
        }

        return $this;
    }

    public function removeMachine(Machine $machine): self
    {
        if ($this->machines->removeElement($machine)) {
            $machine->removeComponent($this);
        }

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        // unset the owning side of the relation if necessary
        if ($article === null && $this->article !== null) {
            $this->article->setComponent(null);
        }

        // set the owning side of the relation if necessary
        if ($article !== null && $article->getComponent() !== $this) {
            $article->setComponent($this);
        }

        $this->article = $article;

        return $this;
    }
}
