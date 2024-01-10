    /**
     * @Route("/book/{book}", name="admin_book_site", requirements={"book"="\d{1,9}"})
     */
    public function bookSiteAction(Book $book): Response
    {
        if ($book->getDeletedAt()) {
            $this->addFlash('danger', 'Ksiazka zostala usunieta');

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/book.html.twig', [
            'book' => $book,
        ]);
    }