<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PlatController extends AbstractController
{
    private $platRepository;

    public function __construct(PlatRepository $platRepository)
    {
        $this->platRepository = $platRepository;
    }

    /**
     * @Route("/plats", name="add_plat", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];
        $description = $data['description'];
        $prix = $data['prix'];
        

        if (empty($nom)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->platRepository->save($nom, $description, $prix);

        return new JsonResponse(['status' => 'Plat created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/plats/{id}", name="get_one_plat", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $plat = $this->platRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $plat->getId(),
            'nom' => $plat->getNom(),
            'description'=>$plat->getDescription(),
            'prix'=>$plat->getPrix(),
            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/plats", name="get_all_plats", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $plats = $this->platRepository->findAll();
        $data = [];

        foreach ($plats as $plat) {
            $data[] = [
                'id' => $plat->getId(),
                'nom' => $plat->getNom(),
                'description'=>$plat->getDescription(),
                'prix'=>$plat->getPrix(),
                
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/plats/{id}", name="update_plat", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $plat = $this->platRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['nom']) ? true : $plat->setNom($data['nom']);
        empty($data['description']) ? true : $plat->setDescription($data['description']);
        empty($data['prix']) ? true : $plat->setPrix($data['prix']);
        

        $updatedPlat = $this->platRepository->update($plat);

        return new JsonResponse($updatedPlat, Response::HTTP_OK);
    }

    /**
     * @Route("/plats/{id}", name="delete_plat", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $plat = $this->platRepository->findOneBy(['id' => $id]);

        $this->platRepository->remove($plat);

        return new JsonResponse(['status' => 'Plat deleted'], Response::HTTP_NO_CONTENT);
    }
}
