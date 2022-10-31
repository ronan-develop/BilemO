<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // mobiles
        $faker = Factory::create('fr_FR');
        $apple = new Brand();
        $apple->setName("Apple");
        $manager->persist($apple);

        $samsung = new Brand();
        $samsung->setName('Samsung');
        $manager->persist($samsung);

        $google = new Brand();
        $google->setName('Google');
        $manager->persist($google);

        // iphone
        for ($i = 11; $i < 15; $i++) {
            $iphone = new Product();
            $iphone->setModel('Iphone' . $i)
                ->setImagePath('https://place-hold.it/300x500?text=' . $iphone->getModel() . '&fontsize=23')
                ->setDescription($faker->paragraphs(2, true))
                ->setBrand($apple)
                ->setPrice(115900);
            $manager->persist($iphone);
        }

        // pixel 6a - 7 - 7Pro
        $pixel6a = new Product();
        $pixel6a->setModel('Pixel 6a')
            ->setDescription($faker->paragraphs(2, true))
            ->setImagePath('https://place-hold.it/300x500?text=' . $pixel6a->getModel() . '&fontsize=23')
            ->setBrand($google)
            ->setPrice(115900);
        $manager->persist($pixel6a);

        $pixel7 = new Product();
        $pixel7->setModel('Pixel 7')
            ->setDescription($faker->paragraphs(2, true))
            ->setImagePath('https://place-hold.it/300x500?text=' . $pixel7->getModel() . '&fontsize=23')
            ->setBrand($google)
            ->setPrice(115900);
        $manager->persist($pixel7);
        $pixel7Pro = new Product();
        $pixel7Pro->setModel('Pixel 7Pro')
            ->setDescription($faker->paragraphs(2, true))
            ->setImagePath('https://place-hold.it/300x500?text=' . $pixel7Pro->getModel() . '&fontsize=23')
            ->setBrand($google)
            ->setPrice(115900);
        $manager->persist($pixel7Pro);

        // GalaxyS22
        $galaxyS22 = new Product();
        $galaxyS22->setModel('GalaxyS22')
            ->setDescription($faker->paragraphs(2, true))
            ->setImagePath('https://place-hold.it/300x500?text=' . $galaxyS22->getModel() . '&fontsize=23')
            ->setBrand($samsung)
            ->setPrice(115900);
        $manager->persist($galaxyS22);

        // clients
        $simpleClient = new Client();
        $simpleClient->setEmail("employee@company.com")
            ->setPassword($this->userPasswordHasher->hashPassword($simpleClient, "password"))
            ->setRoles(['ROLE_USER']);
        $manager->persist($simpleClient);

        $admin = new Client();
        $admin->setEmail("admin@company.com")
            ->setPassword($this->userPasswordHasher->hashPassword($admin, "password"))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        // User
        for ($i = 0;$i<40;$i++){
            $time = (new DateTimeImmutable())
                ->setTime(mt_rand(0, 24), mt_rand(0, 60), mt_rand(0, 60))
                ->setDate(mt_rand(2020, 2022), mt_rand(0, 12), mt_rand(0, 30));
            $user = new User();
            $user->setUsername($faker->name())
                ->setEmail($faker->companyEmail())
                ->setClient($simpleClient)
                ->setCreatedAt($time);
            $manager->persist($user);
        }

        // write in db
        $manager->flush();

    }
}
