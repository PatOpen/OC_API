<?php


namespace App\Controller\Api;


use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

class CustomerAllUsers
{
	/**
	 * @var EntityManagerInterface
	 */
	private EntityManagerInterface $manager;

	public function __construct(EntityManagerInterface $manager)
	{
		$this->manager = $manager;
	}

	public function __invoke(Customer $data)
	{
		dd($data);
	}
}