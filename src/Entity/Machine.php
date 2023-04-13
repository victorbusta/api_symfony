<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MachineRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MachineRepository::class)]
class Machine extends Hardware
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $price_max = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $price_min = null;

    #[ORM\ManyToMany(targetEntity: Component::class, inversedBy: 'machines')]
    #[Groups(['article:read'])]
    private Collection $components;

    #[ORM\OneToOne(mappedBy: 'machine', cascade: ['persist', 'remove'])]
    #[Groups(['article:read'])]
    private ?Article $article = null;

    public function __construct()
    {
        $this->components = new ArrayCollection();
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

    public function getPriceMax(): ?string
    {
        return $this->price_max;
    }

    public function setPriceMax(?string $price_max): self
    {
        $this->price_max = $price_max;

        return $this;
    }

    public function getPriceMin(): ?string
    {
        return $this->price_min;
    }

    public function setPriceMin(?string $price_min): self
    {
        $this->price_min = $price_min;

        return $this;
    }

    /**
     * @return Collection<int, Component>
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(Component $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components->add($component);
        }

        return $this;
    }

    public function removeComponent(Component $component): self
    {
        $this->components->removeElement($component);

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
            $this->article->setMachine(null);
        }

        // set the owning side of the relation if necessary
        if ($article !== null && $article->getMachine() !== $this) {
            $article->setMachine($this);
        }

        $this->article = $article;

        return $this;
    }
}
