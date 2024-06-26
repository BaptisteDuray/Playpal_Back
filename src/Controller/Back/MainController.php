<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/back', name: 'app_back_home')]
    public function home(): Response
    {
        return $this->render('back/main/main.html.twig');
    }
}