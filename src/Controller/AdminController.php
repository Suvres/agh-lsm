<?php


namespace App\Controller;


use App\Entity\Book;
use App\Form\BookForm;
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

    public function __construct(
        EntityManagerInterface $entityManager,
        BookRepository $bookRepository
    )
    {
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
     * @Route("/book", name="admin_book_panel")
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
    public function newBook(Request $request):Response
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
}