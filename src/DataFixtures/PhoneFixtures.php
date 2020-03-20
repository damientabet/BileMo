<?php

namespace App\DataFixtures;

use App\Entity\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PhoneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $phone = new Phone();
        $phone
            ->setBrand('Apple')
            ->setModel("iPhone 11 Pro")
            ->setDescription("Le dernier iPhone de la marque à la pomme")
            ->setPrice("1329")
            ->setColor("Vert nuit")
            ->setOsVersion("iOS 13")
            ->setRomMemory("256")
            ->setScreenResolution("2436 x 1125")
            ->setScreenSize("5.8")
            ->setSpecificAbsorptionRate("0.99")
            ->setYearOfMarketing(new \DateTime("2019-09-20"));
        $manager->persist($phone);

        $manager->flush();
    }
}
