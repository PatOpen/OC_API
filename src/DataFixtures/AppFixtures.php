<?php

namespace App\DataFixtures;

use App\Entity\Color;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
	/**
	 * @var UserPasswordEncoderInterface
	 */
	private UserPasswordEncoderInterface $encoder;

	public function __construct( UserPasswordEncoderInterface $encoder )
	{
		$this->encoder = $encoder;
	}

	public function load( ObjectManager $manager )
	{
		$faker = Factory::create( 'fr_FR' );

		for ($c = 0 ; $c < 3 ; $c++){
			$customer = new Customer();

			$customer->setName($faker->company);

			$manager->persist( $customer );

			for ( $u = 0; $u <= mt_rand(1,5) ; $u ++ )
			{
				$user = new Users();

				$passHash = $this->encoder->encodePassword( $user, 'password' );

				$user->setCustomer($customer)
				     ->setEmail( $faker->email )
				     ->setPassword( $passHash )
				     ->setFirstname( $faker->firstName )
				     ->setLastname( $faker->lastName );

				$manager->persist( $user );
			}
		}

		for ($p = 0 ; $p < 15 ; $p++){
			$product = new Product();

			$product->setBrand($faker->company)
			        ->setDescription($faker->text(100))
			        ->setName($faker->city)
			        ->setPrice($faker->randomFloat(2, 200, 1000));

			$manager->persist($product);

			for ($i = 0 ; $i <= 3 ; $i++){
				$color = new Color();

				$color->setColor($faker->colorName)
					  ->setProduct($product);

				$manager->persist($color);
			}
		}

		$manager->flush();
	}
}
