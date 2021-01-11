<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserDataForm;
use App\Form\UserPasswordForm;
use App\Repository\BookRepository;
use App\Repository\BooksLoansRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class DefaultController.
 *
 * @method User getUser()
 */
class DefaultController extends AbstractController
{
    private Security $security;

    private BooksLoansRepository $booksLoansRepository;

    private BookRepository $bookRepository;

    private EntityManagerInterface $entityManager;

    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        BooksLoansRepository $booksLoansRepository,
        BookRepository $bookRepository,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
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
            'books' => $books,
        ]);
    }

    /**
     * @Route("/account", name="account")
     */
    public function myAccountAction(): Response
    {
        $books = $this->booksLoansRepository->findForUserOrderForLoans($this->getUser());

        return $this->render('default/user_panel.html.twig', [
            'loans' => $books,
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/account/edit", name="user_panel_edit")
     */
    public function accountEdit(Request $request): Response
    {
        $form = $this->createForm(UserDataForm::class, $this->getUser());
        $form2 = $this->createForm(UserPasswordForm::class, $this->getUser());

        $form->handleRequest($request);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Poprawnie zmieniono dane');

            return $this->redirectToRoute('account');
        }

        if ($form2->isSubmitted() && $form2->isValid()) {
            $this->getUser()->setPassword(
                $this->encoder->encodePassword(
                    $this->getUser(),
                    $form2->get('plainPassword')->getData()
                )
            );

            $this->entityManager->flush();
            $this->addFlash('success', 'Poprawnie zmieniono hasło');

            return $this->redirectToRoute('account');
        }

        return $this->render('default/user_account_edit.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }
}
