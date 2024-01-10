<?php

namespace App\Controller;

use App\DTO\BookLoanDTO;
use App\Entity\Book;
use App\Entity\BookCopies;
use App\Entity\BooksLoans;
use App\Entity\User;
use App\Form\BookForm;
use App\Form\BookLoanForm;
use App\Form\UserForm;
use App\Repository\BookCopiesRepository;
use App\Repository\BookRepository;
use App\Repository\BooksLoansRepository;
use App\Repository\UserRepository;
use App\Service\BooksLoansService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private BookRepository $bookRepository;

    private BookCopiesRepository $bookCopiesRepository;

    private BooksLoansService $booksLoansService;

    private UserRepository $userRepository;

    private BooksLoansRepository $booksLoansRepository;

    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        BookRepository $bookRepository,
        BookCopiesRepository $bookCopiesRepository,
        BooksLoansService $booksLoansService,
        UserRepository $userRepository,
        BooksLoansRepository $booksLoansRepository,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
        $this->booksLoansService = $booksLoansService;
        $this->booksLoansRepository = $booksLoansRepository;
        $this->bookCopiesRepository = $bookCopiesRepository;
        $this->bookRepository = $bookRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="admin_panel")
     */
    public function panelAction(): Response
    {
        $users = $this->userRepository->findAll();
        $loans = $this->booksLoansRepository->findAllInLoans(10);
        $bookCopies = $this->bookCopiesRepository->findNonDelete();

        return $this->render('admin/panel.html.twig', [
            'loans' => $loans,
            'users' => $users,
            'bookCopies' => $bookCopies,
        ]);
    }

    /**
     * @Route("/book/panel", name="admin_book_panel")
     */
    public function bookPanelAction(): Response
    {
        $books = $this->bookRepository->findNonDelete();

        return $this->render('admin/book_panel.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/book/new", name="admin_book_panel_new")
     */
    public function newBookAction(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($book);
            $this->entityManager->flush();
            $this->addFlash('success', 'Poprawnie dodano książkę');

            return $this->redirectToRoute('admin_book_panel');
        }

        return $this->render('admin/book_panel_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/book/{book}", name="admin_book_site", requirements={"book"="\d{1,9}"})
     */
    public function bookSiteAction(Book $book): Response
    {
        if ($book->getDeletedAt()) {
            $this->addFlash('danger', 'Książka została usunięta');

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/book.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/book/{book}/new-copy", name="admin_book_copy_new", requirements={"book"="\d{1,9}"})
     */
    public function bookCopyNewAction(Book $book): Response
    {
        if ($book->getDeletedAt()) {
            $this->addFlash('danger', 'Książka została usunięta');

            return $this->redirectToRoute('home');
        }

        $bookCopies = new BookCopies($book);
        $this->entityManager->persist($bookCopies);
        $this->entityManager->flush();
        $this->addFlash('success', 'Poprawnie dodano kopię książki');

        return $this->redirectToRoute('admin_book_site', [
            'book' => $book->getId(),
        ]);
    }

    /**
     * @Route("/book/loans/info", name="admin_loan")
     */
    public function bookLoansInfoAction(): Response
    {
        $books = $this->bookCopiesRepository->findNonDelete();

        return $this->render('admin/book_loan_new.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/book/loans/info/{bookCopy}", name="admin_loan_info", requirements={"bookCopy"="\d{1,9}"}, methods={"POST"})
     */
    public function bookInfoAction(BookCopies $bookCopy): Response
    {
        if ($bookCopy->getBook()->getDeletedAt()) {
            $this->addFlash('danger', 'Książka została usunięta');

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/_book_loan_info.html.twig', [
            'bookCopy' => $bookCopy,
        ]);
    }

    /**
     * @Route("/book/loans/return/{loan}", name="admin_loan_return", requirements={"loan"="\d{1,9}"}, methods={"GET"})
     */
    public function bookLoanReturn(BooksLoans $loan): Response
    {
        $loan->returnBook();
        $this->entityManager->flush();
        $this->addFlash('success', 'Oddano książkę');

        return $this->redirectToRoute('admin_loan');
    }

    /**
     * @Route("/book/loans/new/{bookCopy}", name="admin_loan_new", requirements={"bookCopy"="\d{1,9}"})
     */
    public function bookLoanAction(BookCopies $bookCopy, Request $request): Response
    {
        if ($bookCopy->getBook()->getDeletedAt()) {
            $this->addFlash('danger', 'Książka została usunięta');

            return $this->redirectToRoute('home');
        }

        $bookLoanDTO = new BookLoanDTO();
        $form = $this->createForm(BookLoanForm::class, $bookLoanDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->booksLoansService->borrow($bookLoanDTO, $bookCopy)) {
                $this->entityManager->flush();

                $this->addFlash('success', 'Wypożyczono książkę');
            } else {
                $this->addFlash('danger', 'Nie można wypożyczyć książki, prawdopodobnie przekroczono limit książek');
            }

            return $this->redirectToRoute("admin_loan");
        }

        return $this->render('admin/book_loan_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/panel", name="admin_user_panel")
     */
    public function userPanelAction(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/user_panel.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/new", name="admin_user_panel_new")
     */
    public function newUserAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pass = sprintf('%s.%s', mb_strtolower($user->getName()), mb_strtolower($user->getSurname()));
            $user->setPassword($this->encoder->encodePassword($user, $pass));
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'Poprawnie dodano użytkownika');

            return $this->redirectToRoute('admin_user_panel');
        }

        return $this->render('admin/user_panel_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{user}", name="admin_user_panel_info", requirements={"user"="\d{1,9}"})
     */
    public function userInfoAction(User $user): Response
    {
        return $this->render('admin/user_info.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/book/{book}/edit", name="admin_book_edit", requirements={"book"="\d{1,9}"})
     */
    public function bookEditAction(Book $book, Request $request): Response
    {
        if ($book->getDeletedAt()) {
            $this->addFlash('danger', 'Książka została usunięta');

            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(BookForm::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Poprawnie zapisano dane książki');

            return $this->redirectToRoute('admin_book_site', [
                'book' => $book->getId(),
            ]);
        }

        return $this->render('admin/book_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/book/{book}/delete", name="admin_book_delete", requirements={"book"="\d{1,9}"})
     */
    public function delBookAction(Book $book): Response
    {
        if ($book->getDeletedAt()) {
            $this->addFlash('danger', 'Książka została usunięta');

            return $this->redirectToRoute('home');
        }

        $book->setDeletedAt();
        foreach ($book->getBookCopies() as $copy) {
            foreach ($copy->getBooksLoans() as $loan) {
                if (!$loan->getCommittedAt()) {
                    $loan->returnBook();
                }
            }
        }

        $this->entityManager->flush();
        $this->addFlash('success', 'Poprawnie usunięto książkę');

        return $this->redirectToRoute('home');
    }
}
