<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @Route("/categories", name="add_categorie", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];

        if (empty($nom)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->categorieRepository->save($nom);

        return new JsonResponse(['status' => 'Categorie created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/categories/{id}", name="get_one_categorie", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $categorie = $this->categorieRepository->findOneBy(['id' => $id]);

        if($categorie == null) {
            return new JsonResponse(['status' => 'Categorie not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $categorie->getId(),
            'nom' => $categorie->getNom(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/categories", name="get_all_categories", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $categories = $this->categorieRepository->findAll();
        $data = [];

        foreach ($categories as $categorie) {
            $data[] = [
                'id' => $categorie->getId(),
                'nom' => $categorie->getNom(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/categories/{id}", name="update_categorie", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $categorie = $this->categorieRepository->findOneBy(['id' => $id]);

        if($categorie == null) {
            return new JsonResponse(['status' => 'Categorie not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['nom']) ? true : $categorie->setNom($data['nom']);

        $updatedCategorie = $this->categorieRepository->update($categorie);

        return new JsonResponse($updatedCategorie, Response::HTTP_OK);
    }

    /**
     * @Route("/categories/{id}", name="delete_categorie", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $categorie = $this->categorieRepository->findOneBy(['id' => $id]);

        if($categorie == null) {
            return new JsonResponse(['status' => 'Categorie not found!'], Response::HTTP_NOT_FOUND);
        }

        $this->categorieRepository->remove($categorie);

        return new JsonResponse(['status' => 'Categorie deleted'], Response::HTTP_NO_CONTENT);
    }



}
