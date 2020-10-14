<?php


namespace App\Tests\Unit;


use App\Entity\Customer;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
	/**
	 * @var User
	 */
	private $user;

	protected function setUp(): void
	{
		parent::setUp();

		$this->user = new User();
	}

	public function testGetEmail(): void
	{
		$value = 'test@test.fr';

		$response = $this->user->setEmail($value);

		self::assertInstanceOf(User::class, $response);
		self::assertEquals($value, $this->user->getEmail());
		self::assertEquals($value, $this->user->getUsername());
	}

	public function testGetRoles(): void
	{
		$value = ["ROLE_ADMIN"];

		$response = $this->user->setRoles($value);

		self::assertInstanceOf(User::class, $response);
		self::assertContains('ROLE_USER', $this->user->getRoles());
		self::assertContains('ROLE_ADMIN', $this->user->getRoles());

	}

	public function testGetPassword(): void
	{
		$value = 'password';

		$response = $this->user->setPassword($value);

		self::assertInstanceOf(User::class, $response);
		self::assertContains($value, $this->user->getPassword());
	}

	public function testGetCustomer(): void
	{
		$value = new Customer();

		$response = $this->user->setCustomer($value);

		self::assertInstanceOf(User::class, $response);
		self::assertEquals($value, $this->user->getCustomer());
	}

	public function testGetFirstname(): void
	{
		$value = 'Nico';

		$response = $this->user->setFirstname($value);

		self::assertInstanceOf(User::class, $response);
		self::assertEquals($value, $this->user->getFirstname());
	}

	public function testGetLastname(): void
	{
		$value = 'Dupont';

		$response = $this->user->setLastname($value);

		self::assertInstanceOf(User::class, $response);
		self::assertEquals($value, $this->user->getLastname());
	}

}