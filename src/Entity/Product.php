<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"product:read"}},
 *     collectionOperations={
 *          "get"
 *     },
 *     itemOperations={
 *          "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product:read"})
     */
	private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     */
	private ?string $brand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     */
	private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     */
	private ?string $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"product:read"})
     */
	private ?float $price;

    /**
     * @ORM\OneToMany(targetEntity=Color::class, mappedBy="product", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"product:read"})
     */
	private Collection $color;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="product", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"product:read"})
     */
	private Collection $image;

    public function __construct()
    {
        $this->color = new ArrayCollection();
        $this->image = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Color[]
     */
    public function getColor(): Collection
    {
        return $this->color;
    }

    public function addColor(Color $color): self
    {
        if (!$this->color->contains($color)) {
            $this->color[] = $color;
            $color->setProduct($this);
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->color->contains($color)) {
            $this->color->removeElement($color);
            // set the owning side to null (unless already changed)
            if ($color->getProduct() === $this) {
                $color->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }
}
