<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormuleController extends AbstractController
{
    #[Route('/formule', name: 'app_formule')]
    public function index(): Response
    {
        return $this->render('formule/index.html.twig', [
            'controller_name' => 'FormuleController',
        ]);
    }
}
