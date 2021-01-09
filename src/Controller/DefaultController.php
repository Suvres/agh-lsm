<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DefaultController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
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

        return $this->redirectToRoute('admin_panel');
    }
}
