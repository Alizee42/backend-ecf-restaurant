<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceDisponibleController extends AbstractController
{
    #[Route('/place/disponible', name: 'app_place_disponible')]
    public function index(): Response
    {
        return $this->render('place_disponible/index.html.twig', [
            'controller_name' => 'PlaceDisponibleController',
        ]);
    }
}
