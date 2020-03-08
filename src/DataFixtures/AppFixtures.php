<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Adherent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager) 
    {

        

        $faker = Factory::create('fr_FR');

        for($a = 1; $a <= 50; $a++)
     {

        $adherent = new Adherent();

        $adherent->setLastName($faker->lastName)
                 ->setFirstName($faker->firstName())
                 ->setBorn($faker->dateTimeAD($max = 'now', $timezone = null))
                 ->setSubCategory($faker->randomElement(['baby','u 10','u 11','u 12','u 13','u 14','u 15','u 16','u 17', 'u 18','senior']))
                 ->setToNumber($faker->randomNumber($nbDigits = NULL, $strict = false))
                 ->setSex($faker->randomElement(['M','F']))
                 ->setComplement($faker->secondaryAddress)
                 ->setAddress($faker->address)
                 ->setLieut($faker->city)
                 ->setPostalCode($faker->randomNumber($nbDigits = NULL, $strict = false))
                 ->setCity($faker->city)
                 ->setRecord($faker->dateTimeAD($max = 'now', $timezone = null))
                 ->setLicenceType($faker->catchPhrase)
                 ->setHomePhone($faker->phoneNumber)
                 ->setMobilePhone($faker->phoneNumber)
                 ->setFax($faker->phoneNumber)
                 ->setEmail($faker->email)
                 ->setCategoryArbitre($faker->randomElement(['Amateur','Professionel']))
                 ->setPlaceOfBirth($faker->city)
                 ->setClubChange($faker->city)
                 ->setClubOut($faker->city);

                 $manager->persist($adherent);
        // $product = new Product();
        // $manager->persist($product);
     }

        $manager->flush();
    }
}
