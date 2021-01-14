<?php

namespace Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserDataTest extends WebTestCase
{
    public function testChangeData(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $client->followRedirect();
        $form = $client->getCrawler()->filter('form')->form([
            'email' => 'user@user.pl',
            'password' => 'error',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertStringContainsString('Invalid credentials.', $client->getCrawler()->text());

        $form = $client->getCrawler()->filter('form')->form([
            'email' => 'user@user.pl',
            'password' => 'test_pass',
        ]);
        $client->submit($form);
        $client->followRedirect();
        $client->followRedirect();
        self::assertStringContainsString('Wypożyczenia', $client->getCrawler()->text());
        self::assertStringContainsString('Edytuj dane', $client->getCrawler()->text());

        $client->clickLink('Edytuj dane');
        $form = $form = $client->getCrawler()->filter('form')->form([
            'user_data_form[name]' => 'Test',
            'user_data_form[surname]' => 'Test',
            'user_data_form[email]' => 'test@test.pl',
            'user_data_form[birthDate][month]' => 1,
            'user_data_form[birthDate][day]' => 1,
            'user_data_form[birthDate][year]' => 1999,
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertStringContainsString('test@test.pl', $client->getCrawler()->text());
        self::assertStringContainsString('Poprawnie zmieniono dane', $client->getCrawler()->text());

        $client->clickLink('Wyloguj się');
        $client->followRedirect();
        $client->followRedirect();
        self::assertStringContainsString('Zaloguj się', $client->getCrawler()->text());
    }
}
