<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoadBookFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $b = new Book();
        $b->setAgeThreshold(18);
        $b->setAuthor('Admin');
        $b->setBrand(Book::EPIKA);
        $b->setTitle('Test Book');
        $this->setReference('book_18', $b);
        $manager->persist($b);

        $b1 = new Book();
        $b1->setAgeThreshold(10);
        $b1->setAuthor('Admin');
        $b1->setBrand(Book::DRAMAT);
        $b1->setTitle('Test Book Child');
        $this->setReference('book_10', $b1);
        $manager->persist($b1);

        $manager->flush();
    }
}
