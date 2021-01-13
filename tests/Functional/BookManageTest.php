<?php

namespace Functional;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookManageTest extends WebTestCase
{
    public function testBookManager(): void
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $bookRepository = static::$container->get(BookRepository::class);

        $book = $bookRepository->findBy([
            'title' => 'Test Book',
        ])[0];
        \assert($book instanceof Book);

        $client->loginUser($userRepository->findBy([
            'email' => 'admin@admin.pl',
        ])[0]);
        $client->request('GET', '/admin/book/panel');
        self::assertStringContainsString('Test Book', $client->getCrawler()->text());

        $client->clickLink('Test Book');
        self::assertStringContainsString('Dodaj kopię', $client->getCrawler()->text());
        self::assertStringContainsString('1', $client->getCrawler()->filter('table > tbody > tr:nth-child(4) > td')->text());

        $client->request('GET', sprintf('/admin/book/%s/new-copy', $book->getId()));
        $client->followRedirect();
        self::assertStringContainsString('2', $client->getCrawler()->filter('table > tbody > tr:nth-child(4) > td')->text());

        $client->request('GET', sprintf('/admin/book/%s/edit', $book->getId()));
        self::assertStringContainsString('Zapisz', $client->getCrawler()->text());

        $form = $client->getCrawler()->filter('form')->form([
            'book_form[title]' => 'Nowy Test Book',
            'book_form[author]' => 'Nowy Autor',
            'book_form[brand]' => 'Liryka',
            'book_form[ageThreshold]' => 10,
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertStringContainsString('Nowy Test Book', $client->getCrawler()->text());

        $client->request('GET', sprintf('/admin/book/%s/delete', $book->getId()));
        $client->followRedirect();
        $client->followRedirect();
        self::assertStringContainsString('Poprawnie usunięto książkę', $client->getCrawler()->text());

        $client->request('GET', '/admin/book/new');
        self::assertStringContainsString('Nowa książka', $client->getCrawler()->text());

        $form = $client->getCrawler()->filter('form')->form([
            'book_form[title]' => 'Book',
            'book_form[author]' => 'Autor',

            'book_form[brand]' => 'Dramat',

            'book_form[ageThreshold]' => 18,
        ]);

        $client->submit($form);
        $client->followRedirect();

        self::assertStringContainsString('Poprawnie dodano książkę', $client->getCrawler()->text());
        self::assertStringContainsString('Dramat', $client->getCrawler()->text());
    }
}
