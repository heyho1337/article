<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['article:read']],
    cacheHeaders: [
        'max_age' => 3600,
        'shared_max_age' => 3600,
        'public' => true,
    ],
    operations: [
        new Get(),
        new GetCollection(),
    ],
    security: "is_granted('ROLE_API')"
)]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    private static string $currentLang = 'en';

    // JSON translation storage
    #[ORM\Column(type: Types::JSON)]
    #[Groups(['article:read'])]
    private array $name = [];

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['article:read'])]
    private array $text = [];

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['article:read'])]
    private array $title = [];

    #[ORM\Column(type: Types::JSON)]
    private array $meta_desc = [];

    // Standard columns
    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['article:read'])]
    private ?string $image = null;

    public function __construct()
    {
        $this->name = [];
        $this->text = [];
        $this->title = [];
        $this->meta_desc = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // Smart getters/setters
    public function getName(?string $lang = null): ?string
    {
        $lang = $lang ?? self::$currentLang;
        return $this->name[$lang] ?? $this->name['en'] ?? null;
    }

    public function setName(?string $value, ?string $lang = null): static
    {
        $lang = $lang ?? self::$currentLang;
        $this->name[$lang] = $value;
        return $this;
    }

    public function getText(?string $lang = null): ?string
    {
        $lang = $lang ?? self::$currentLang;
        return $this->text[$lang] ?? $this->text['en'] ?? null;
    }

    public function setText(?string $value, ?string $lang = null): static
    {
        $lang = $lang ?? self::$currentLang;
        $this->text[$lang] = $value;
        return $this;
    }

    public function getTitle(?string $lang = null): ?string
    {
        $lang = $lang ?? self::$currentLang;
        return $this->title[$lang] ?? $this->title['en'] ?? null;
    }

    public function setTitle(?string $value, ?string $lang = null): static
    {
        $lang = $lang ?? self::$currentLang;
        $this->title[$lang] = $value;
        return $this;
    }

    public function getMetaDesc(?string $lang = null): ?string
    {
        $lang = $lang ?? self::$currentLang;
        return $this->meta_desc[$lang] ?? $this->meta_desc['en'] ?? null;
    }

    public function setMetaDesc(?string $value, ?string $lang = null): static
    {
        $lang = $lang ?? self::$currentLang;
        $this->meta_desc[$lang] = $value;
        return $this;
    }

    // Methods to get/set all translations
    public function getNameTranslations(): array
    {
        return $this->name;
    }

    public function setNameTranslations(array $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getTextTranslations(): array
    {
        return $this->text;
    }

    public function setTextTranslations(array $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function getTitleTranslations(): array
    {
        return $this->title;
    }

    public function setTitleTranslations(array $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getMetaDescTranslations(): array
    {
        return $this->meta_desc;
    }

    public function setMetaDescTranslations(array $meta_desc): static
    {
        $this->meta_desc = $meta_desc;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeImmutable $modified_at): static
    {
        $this->modified_at = $modified_at;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public static function setCurrentLang(string $lang): void
    {
        self::$currentLang = $lang;
    }

    public static function getCurrentLang(): string
    {
        return self::$currentLang;
    }

    public function __toString(): string
    {
        return $this->getName() ?? '';
    }
}
