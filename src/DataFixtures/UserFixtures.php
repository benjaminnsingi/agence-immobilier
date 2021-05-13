<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_FR');
        for ($i = 0; $i< 12; $i++ ) {
            $user = new User();
            $user
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setEmail($faker->email)
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->encoder->encodePassword($user, '123456'));

            $manager->persist($user);
        }
        $manager->flush();
    }
}