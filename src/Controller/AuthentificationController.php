<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CompteUtilisateurRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthentificationController extends AbstractController
{
    private $compteUtilisateurRepository;

    public function __construct(CompteUtilisateurRepository $compteUtilisateurRepository)
    {
        $this->compteUtilisateurRepository = $compteUtilisateurRepository;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];

        $utilisateur = $this->compteUtilisateurRepository->findOneBy(
            [
                'email' => $email,
                'password' => $password
            ]
        );

        if($utilisateur == null) {
            return new JsonResponse(['status' => 'Email ou mot de passe invalide'], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['status' => 'Compte utilisateur trouvé'], Response::HTTP_OK);
    }
}
