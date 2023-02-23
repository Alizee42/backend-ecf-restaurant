<?php

namespace App\Controller;

use App\Repository\CompteUtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CompteUtilisateurController extends AbstractController
{
    private $compteUtilisateurRepository;

    public function __construct(CompteUtilisateurRepository $compteUtilisateurRepository)
    {
        $this->compteUtilisateurRepository = $compteUtilisateurRepository;
    }

    /**
     * @Route("/utilisateurs", name="add_compte_utilisateur", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $role = $data['role'];
        $estActif = $data['estActif'];

        if (empty($email)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->compteUtilisateurRepository->save($email, $password, $role, $estActif);

        return new JsonResponse(['status' => 'Compte utilisateur created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/utilisateurs/{id}", name="get_one_compte_utilisateur", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $utilisateur = $this->compteUtilisateurRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $utilisateur->getId(),
            'email' => $utilisateur->getEmail(),
            'password'=>$utilisateur->getPassword(),
            'role'=>$utilisateur->getRole(),
            'estActif'=>$utilisateur->isEstActif(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/utilisateurs", name="get_all_utilisateurs", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $utilisateurs = $this->compteUtilisateurRepository->findAll();
        $data = [];

        foreach ($utilisateurs as $utilisateur) {
            $data[] = [
                'id' => $utilisateur->getId(),
            'email' => $utilisateur->getEmail(),
            'password'=>$utilisateur->getPassword(),
            'role'=>$utilisateur->getRole(),
            'estActif'=>$utilisateur->isEstActif(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/utilisateurs/{id}", name="update_utilisateur", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $utilisateur = $this->compteUtilisateurRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['email']) ? true : $utilisateur->setEmail($data['email']);
        empty($data['password']) ? true : $utilisateur->setPassword($data['password']);
        empty($data['role']) ? true : $utilisateur->setRole($data['role']);
        empty($data['estActif']) ? true : $utilisateur->setEstActif($data['estActif']);

        $updatedUtilisateur = $this->compteUtilisateurRepository->update($utilisateur);

        return new JsonResponse($updatedUtilisateur, Response::HTTP_OK);
    }

    /**
     * @Route("/utilisateurs/{id}", name="delete_utilisateur", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $utilisateur = $this->compteUtilisateurRepository->findOneBy(['id' => $id]);

        $this->compteUtilisateurRepository->remove($utilisateur);

        return new JsonResponse(['status' => 'Compte utilisateur deleted'], Response::HTTP_NO_CONTENT);
    }

}
