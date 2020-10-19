<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private ?int $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Groups({"users:read"})
	 */
	private ?string $name;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private DateTime $createdAt;

	/**
	 * @ORM\OneToMany(targetEntity=Users::class, mappedBy="customer", orphanRemoval=true, cascade={"persist", "remove"})
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
