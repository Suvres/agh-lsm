<?php


namespace Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 */
class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function indexAction(): Response
    {

        return $this->render("default/index.html.twig");
    }
}