<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\BooksLoansRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class DefaultController
 * @method User getUser()
 */
class DefaultController extends AbstractController
{
    private Security $security;
    /**
     * @var BooksLoansRepository
     */
    private BooksLoansRepository $booksLoansRepository;
    /**
     * @var BookRepository
     */
    private BookRepository $bookRepository;

    public function __construct(Security $security, BooksLoansRepository $booksLoansRepository, BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->booksLoansRepository = $booksLoansRepository;
        $this->security = $security;
    }

    /**
     * @Route("/", name="home")
     */
    public function indexAction(): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_panel');
        }

        return $this->redirectToRoute('account');
    }

    /**
     * @Route("/book/search", name="book_search")
     */
    public function booksSearchAction(): Response
    {
        $books = $this->bookRepository->findAll();
        return $this->render('default/user_book_search.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/account", name="account")
     */
    public function myAccountAction(): Response
    {

        $books = $this->booksLoansRepository->findForUserOrderForLoans($this->getUser());
        return $this->render('default/user_panel.html.twig', [
            'loans' => $books
        ]);
    }
}
