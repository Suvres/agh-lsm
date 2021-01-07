<?php


namespace App\DataFixtures;

use App\Entity\BookCopies;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadBookCopyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $b18 = $this->getReference("book_18");
        $bc = new BookCopies($b18);

        $manager->persist($bc);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          LoadBookFixtures::class
        ];
    }
}
