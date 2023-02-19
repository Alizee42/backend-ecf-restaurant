<?php

namespace App\DataFixtures;

use App\Entity\CompteUtilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        /*
        $ROLE_ADMIN = "administrateur";

        $user = new CompteUtilisateur();
        $user->setEmail("quaiantique@admin.com");
        $user->setPassword("12345");
        $user->setEstActif(true);
        $user->setRole($ROLE_ADMIN);
        $manager->persist($user);
        $manager->flush();
        */

    }
}
