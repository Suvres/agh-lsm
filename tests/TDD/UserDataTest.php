<?php


namespace TDD;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserDataTest extends WebTestCase
{
    public function testChangeData(): void
    {
        $client = static::createClient();

        $client->request("GET", "/");
        $client->followRedirect();
        $form = $client->getCrawler()->filter('form')->form([
           'email' => 'user@user.pl',
            'password' => 'error'
        ]);
        $client->submit($form);
        $client->followRedirect();

        self::assertStringContainsString('Invalid credentials.', $client->getCrawler()->text());

        $form = $client->getCrawler()->filter('form')->form([
            'email' => 'user@user.pl',
            'password' => 'test_pass'
        ]);
        $client->submit($form);
        $client->followRedirect();
        $client->followRedirect();
        self::assertStringContainsString('Wypożyczenia', $client->getCrawler()->text());

        $client->clickLink("Edytuj dane");
        self::assertStringContainsString('Edytuj Dane', $client->getCrawler()->text());
        $data = new \DateTime("-18 years");

        $form = $form = $client->getCrawler()->filter('form')->form([
            'user_data["name"]' => 'Test',
            'user_data["surname"]' => 'Test',
            'user_data["email"]' => 'test@test.pl',
            'user_data["password"]' => 'test.test',
            'user_data["birthDate"]' => $data->format('Y-m-d'),
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertStringContainsString('test@test.pl', $client->getCrawler()->text());
        self::assertStringContainsString('Zmieniono dane', $client->getCrawler()->text());

        $client->clickLink('Wyloguj się');
        $client->followRedirect();
        self::assertStringContainsString('Zaloguj się', $client->getCrawler()->text());
    }
}