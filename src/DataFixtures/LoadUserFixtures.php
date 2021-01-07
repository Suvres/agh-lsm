<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoadUserFixtures extends Fixture
{

    /**
     * password: test_pass
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setRoles(["ROLE_ADMIN"]);
        $user->setBirthDate(new \DateTime("-20 years"));
        $user->setEmail("admin@admin.pl");
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$7qPOs1KcljROyIgm3G3AYw$gUwk3mDYaBffutGlDjQJIU2XQ5jKp2blRUvdDWC7Cbw');
        $user->setName("admin");
        $user->setSurname("admin");
        $this->setReference("admin", $user);

        $user1 = new User();
        $user1->setBirthDate(new \DateTime("-10 years"));
        $user1->setEmail("user@user.pl");
        $user1->setPassword('$argon2id$v=19$m=65536,t=4,p=1$7qPOs1KcljROyIgm3G3AYw$gUwk3mDYaBffutGlDjQJIU2XQ5jKp2blRUvdDWC7Cbw');
        $user1->setName("user");
        $user1->setSurname("user");
        $this->setReference("user", $user1);


        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}