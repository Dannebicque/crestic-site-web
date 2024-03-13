<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HceresController extends AbstractController
{
    #[Route(path: '/pages/hceres/', name: 'hceres')]
    public function index(): Response
    {
        return $this->render('hceres/index.html.twig');
    }
}
