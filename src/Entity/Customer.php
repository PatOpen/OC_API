<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CustomerRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"customers:read"}},
 *     denormalizationContext={"groups"={"customers:write"}},
 *     collectionOperations={
 *          "GET"={},
 *          "customers_all_users"={
 *              "method"="GET",
 *              "path"="/customers/{id}/users",
 *              "controller"="App\Controller\Api\CustomerAllUsers"
 *     }
 *     },
 *     itemOperations={
 *           "GET"={}
 *     }
 * )
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 * @Groups({"customers:read"})
	 */
	private ?int $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Groups({"users:read", "customers:read"})
	 */
	private ?string $name;

	/**
	 * @ORM\Column(type="datetime")
	 * @Groups({"customers:read"})
	 */
	private DateTime $createdAt;

	/**
	 * @ORM\OneToMany(targetEntity=Users::class, mappedBy="customer", orphanRemoval=true, cascade={"persist", "remove"})
	 * @Groups({"customers:read"})
	 */
	private Collection $user;

	public function __construct()
	{
		$this->createdAt = new DateTime;
		$this->user      = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName( string $name ): self
	{
		$this->name = $name;

		return $this;
	}

	public function getCreatedAt(): ?DateTimeInterface
	{
		return $this->createdAt;
	}

	/**
	 * @return Collection|Users[]
	 */
	public function getUser(): Collection
	{
		return $this->user;
	}

	public function addUser( Users $user ): self
	{
		if ( ! $this->user->contains( $user ) )
		{
			$this->user[] = $user;
			$user->setCustomer( $this );
		}

		return $this;
	}

	public function removeUser( Users $user ): self
	{
		if ( $this->user->contains( $user ) )
		{
			$this->user->removeElement( $user );
			// set the owning side to null (unless already changed)
			if ( $user->getCustomer() === $this )
			{
				$user->setCustomer( null );
			}
		}

		return $this;
	}
}
