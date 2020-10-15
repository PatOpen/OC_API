<?php


namespace App\Tests\Unit;


use App\Entity\Color;
use App\Entity\Image;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
	/**
	 * @var Product
	 */
	private $product;

	protected function setUp(): void
	{
		parent::setUp();

		$this->product = new Product();
	}

	public function testGetBrand()
	{
		$value = 'Samsung';

		$response = $this->product->setBrand($value);

		self::assertInstanceOf(Product::class, $response);
		self::assertEquals($value, $this->product->getBrand());
	}

	public function testGetDescription()
	{
		$value = 'Ce téléphone est une terrible !';

		$response = $this->product->setDescription($value);

		self::assertInstanceOf(Product::class, $response);
		self::assertEquals($value, $this->product->getDescription());

	}

	public function testGetName()
	{
		$value = 'Galaxy Note';

		$response = $this->product->setName($value);

		self::assertInstanceOf(Product::class, $response);
		self::assertEquals($value, $this->product->getName());
	}

	public function testGetImage()
	{
		$value = new Image();

		$response = $this->product->addImage($value);

		self::assertInstanceOf(Product::class, $response);
		self::assertCount(1, $this->product->getImage());
		self::assertTrue($this->product->getImage()->contains($value));

		$response = $this->product->removeImage($value);

		self::assertInstanceOf(Product::class, $response);
		self::assertCount(0, $this->product->getImage());
		self::assertFalse($this->product->getImage()->contains($value));
	}

	public function testGetColor()
	{
		$value = new Color();

		$response = $this->product->addColor($value);

		self::assertInstanceOf(Product::class, $response);
		self::assertCount(1, $this->product->getColor());
		self::assertTrue($this->product->getColor()->contains($value));

		$response = $this->product->removeColor($value);

		self::assertInstanceOf(Product::class, $response);
		self::assertCount(0, $this->product->getColor());
		self::assertFalse($this->product->getColor()->contains($value));
	}

}