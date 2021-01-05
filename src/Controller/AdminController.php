<?php


namespace App\Controller;


use App\Entity\Book;
use App\Entity\BookCopies;
use App\Form\BookForm;
use App\Repository\BookCopiesRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var BookRepository
     */
    private BookRepository $bookRepository;
    /**
     * @var BookCopiesRepository
     */
    private BookCopiesRepository $bookCopiesRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        BookRepository $bookRepository,
        BookCopiesRepository $bookCopiesRepository
    )
    {
        $this->bookCopiesRepository = $bookCopiesRepository;
        $this->bookRepository = $bookRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="admin_panel")
     */
    public function panelAction(): Response
    {
        return $this->render("admin/panel.html.twig");
    }

    /**
     * @Route("/book/panel", name="admin_book_panel")
     */
    public function bookPanelAction(): Response
    {
        $books = $this->bookRepository->findNonDelete();
        return $this->render("admin/book_panel.html.twig", [
            'books' => $books
        ]);
    }

    /**
     * @Route("/book/new", name="admin_book_panel_new")
     */
    public function newBookAction(Request $request):Response
    {
        $book = new Book();
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($book);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_book_panel');
        }

        return $this->render("admin/book_panel_new.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/book/{book}", name="admin_book_site", requirements={"book":"\d{1,9}"})
     */
    public function bookSiteAction(Book $book): Response
    {
        return $this->render('admin/book.html.twig', [
            "book" => $book
        ]);
    }

    /**
     * @Route("/book/{book}/new-copy", name="admin_book_copy_new", requirements={"book":"\d{1,9}"})
     */
    public function bookCopyNewAction(Book $book, Request $request): Response
    {
        $bookCopies = new BookCopies($book);
        $this->entityManager->persist($bookCopies);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_book_site', ['book' => $book->getId()]);
    }

    /**
     * @Route("/book/loans/new", name="admin_loan_new")
     */
    public function bookLoadAction(Request $request): Response
    {
        $books = $this->bookCopiesRepository->findAll();
        return $this->render('admin/book_loan_new.html.twig', ['books' => $books]);
    }

    /**
     * @Route("/book/loans/info/{bookCopy}", name="admin_loan_info", requirements={"bookCopy":"\d{1,9}"}, methods={"POST"})
     */
    public function bookInfoAction(BookCopies $bookCopy, Request $request): Response
    {
        return $this->render('admin/_book_loan_info.html.twig', ['bookCopy' => $bookCopy]);
    }
}