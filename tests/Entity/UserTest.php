<?php

namespace Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUser(): void
    {
        $d = new \DateTime('-18 years');

        $u = new User();
        $u->setPassword('test');
        $u->setName('test');
        $u->setEmail('test@test.pl');
        $u->setBirthDate($d);
        $u->setSurname('test');

        self::assertEquals('test', $u->getPassword());
        self::assertEquals($d, $u->getBirthDate());
        self::assertEquals('test', $u->getName());
        self::assertEquals('test@test.pl', $u->getEmail());
        self::assertEquals('test', $u->getSurname());
    }
}
