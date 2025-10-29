<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[Groups(['article:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name_hu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name_en = null;

    #[Groups(['article:read'])]
    private ?string $text = null;

     #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text_hu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text_en = null;

    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?\DateTimeImmutable $modified_at = null;

    #[Groups(['article:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title_hu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title_en = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['article:read'])]
    private ?string $image = null;

    private ?string $meta_desc = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_desc_hu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_desc_en = null;

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNameHu(): ?string
    {
        return $this->name_hu;
    }

    public function setNameHu(string $name_hu): static
    {
        $this->name_hu = $name_hu;

        return $this;
    }

    public function getNameEn(): ?string
    {
        return $this->name_en;
    }

    public function setNameEn(?string $name_en): static
    {
        $this->name_en = $name_en;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getTextHu(): ?string
    {
        return $this->text_hu;
    }

    public function setTextHu(string $text_hu): static
    {
        $this->text_hu = $text_hu;

        return $this;
    }

    public function getTextEn(): ?string
    {
        return $this->text_en;
    }

    public function setTextEn(?string $text_en): static
    {
        $this->text_en = $text_en;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitleHu(): ?string
    {
        return $this->title_hu;
    }

    public function setTitleHu(string $title_hu): static
    {
        $this->title_hu = $title_hu;

        return $this;
    }

    public function getTitleEn(): ?string
    {
        return $this->title_en;
    }

    public function setTitleEn(?string $title_en): static
    {
        $this->title_en = $title_en;

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

    public function __toString(): string
    {
        $getter = 'getName' . self::$currentLang;
        if (method_exists($this, $getter)) {
            return (string) $this->$getter();
        }

        return '';
    }

    public function getMetaDesc(): ?string
    {
        return $this->meta_desc;
    }

    public function setMetaDesc(?string $meta_desc): static
    {
        $this->meta_desc = $meta_desc;

        return $this;
    }

    public function getMetaDescHu(): ?string
    {
        return $this->meta_desc_hu;
    }

    public function setMetaDescHu(?string $meta_desc_hu): static
    {
        $this->meta_desc_hu = $meta_desc_hu;

        return $this;
    }

    public function getMetaDescEn(): ?string
    {
        return $this->meta_desc_en;
    }

    public function setMetaDescEn(?string $meta_desc_en): static
    {
        $this->meta_desc_en = $meta_desc_en;

        return $this;
    }
}
