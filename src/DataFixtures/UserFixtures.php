<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
       $admin = new User();

       $admin
           ->setLastname('doe')
           ->setFirstname('john')
           ->setEmail('john.doe@benshop.com')
           ->setPassword(
               $this->passwordEncoder->encodePassword($admin, 'admin123')
           )
           ->setRoles(User::ROLE_ADMIN)
       ;
      $manager->persist($admin);

       $faker = Factory::create('fr_FR');
       $author = array();
        for ($i = 0; $i< 20; $i++) {
            $author[$i] = new User();
            $author[$i]->setLastname($faker->lastName);
            $author[$i]->setFirstname($faker->firstName);
            $author[$i]->setEmail($faker->email);
            $author[$i]->setRoles(User::ROLE_USER);
            $author[$i]->setPassword(
                $this->passwordEncoder->encodePassword($author[$i], 'user123')
            );
            $manager->persist($author[$i]);
        }
        $manager->flush();
    }
}