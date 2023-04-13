<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\CreateController\CreateCommentController;
use App\Controller\CreateController\CreateMachineController;
use App\Controller\CreateController\CreateDocumentController;
use App\Controller\CreateController\CreateComponentController;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            name: 'machine', 
            uriTemplate: '/articles/machine', 
            controller: CreateMachineController::class,
            openapiContext: [
                'summary' => 'Create a machine', 
                'description' => 'Create a machine with its associated article', 
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'name' => ['type' => 'string'], 
                                    'description' => ['type' => 'string'],
                                    'brand' => ['type' => 'string'],
                                    'priceMax' => ['type' => 'string'],
                                    'priceMin' => ['type' => 'string'],
                                ]
                            ], 
                            'example' => [
                                'name' => 'MS-20', 
                                'description' => 'A popular korg synth',
                                'brand' => 'Korg',
                                'priceMax' => '500€',
                                'priceMin' => '300€',
                            ]
                        ]
                    ]
                ]
            ]
        ),
        new Post(
            name: 'component', 
            uriTemplate: '/articles/component', 
            controller: CreateComponentController::class,
            openapiContext: [
                'summary' => 'Create a component', 
                'description' => 'Create a component with its associated article', 
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'name' => ['type' => 'string'], 
                                    'description' => ['type' => 'string'],
                                    'brand' => ['type' => 'string'],
                                ]
                            ], 
                            'example' => [
                                'name' => '555 timer IC', 
                                'description' => 'An integrated circuit (chip) used in a variety of timer, delay, pulse generation, and oscillator applications',
                                'brand' => 'Brandless',
                            ]
                        ]
                    ]
                ]
            ]
        ),
        new Post(
            name: 'document', 
            uriTemplate: '/articles/{article_id}/document', 
            controller: CreateDocumentController::class,
            openapiContext: [
                'summary' => 'add a document', 
                'description' => 'Create a document to an article', 
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'name' => ['type' => 'string'], 
                                    'description' => ['type' => 'string'],
                                    'brand' => ['type' => 'string'],
                                    'priceMax' => ['type' => 'string'],
                                    'priceMin' => ['type' => 'string'],
                                ]
                            ], 
                            'example' => [
                                'name' => 'MS-20', 
                                'description' => 'A popular korg synth',
                                'brand' => 'Korg',
                                'priceMax' => '500€',
                                'priceMin' => '300€',
                            ]
                        ]
                    ]
                ]
            ]
        ),
        new Post(
            name: 'comment', 
            uriTemplate: '/articles/{article_id}/comment/{comment_id}', 
            controller: CreateCommentController::class,
            openapiContext: [
                'summary' => 'add a comment', 
                'description' => 'Create a comment to an article or an other comment', 
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'content' => ['type' => 'string'], 
                                    'description' => ['type' => 'string'],
                                    'brand' => ['type' => 'string'],
                                    'priceMax' => ['type' => 'string'],
                                    'priceMin' => ['type' => 'string'],
                                ]
                            ], 
                            'example' => [
                                'name' => 'MS-20', 
                                'description' => 'A popular korg synth',
                                'brand' => 'Korg',
                                'priceMax' => '500€',
                                'priceMin' => '300€',
                            ]
                        ]
                    ]
                ]
            ]
        ),
        new Delete(),
        new Patch(),
    ],
    normalizationContext: ['groups' => ['article:read']],
)]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article:read', 'article_type:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read', 'article_type:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['article:read', 'article_type:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['article:read', 'article_type:read'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read', 'article_type:read'])]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read', 'article_type:read'])]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['article_type:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArticleType $article_type = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'articles')]
    #[Groups(['article:read'])]
    private ?self $article = null;

    #[ORM\OneToOne(inversedBy: 'article', cascade: ['persist', 'remove'])]
    #[Groups(['article:read'])]
    private ?Component $component = null;

    #[ORM\OneToOne(inversedBy: 'article', cascade: ['persist', 'remove'])]
    #[Groups(['article:read'])]
    private ?Machine $machine = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: self::class)]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Document::class)]
    private Collection $documents;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?\DateTimeImmutable $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getArticleType(): ?ArticleType
    {
        return $this->article_type;
    }

    public function setArticleType(?ArticleType $article_type): self
    {
        $this->article_type = $article_type;

        return $this;
    }

    public function getArticle(): ?self
    {
        return $this->article;
    }

    public function setArticle(?self $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getComponent(): ?Component
    {
        return $this->component;
    }

    public function setComponent(?Component $component): self
    {
        $this->component = $component;

        return $this;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): self
    {
        $this->machine = $machine;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(self $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setArticle($this);
        }

        return $this;
    }

    public function removeArticle(self $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticle() === $this) {
                $article->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setArticle($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getArticle() === $this) {
                $document->setArticle(null);
            }
        }

        return $this;
    }
}
