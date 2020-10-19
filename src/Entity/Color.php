<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
	private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     */
	private ?string $color;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="color")
     * @ORM\JoinColumn(nullable=false)
     */
	private ?Product $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
