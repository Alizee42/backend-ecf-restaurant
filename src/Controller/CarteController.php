<?php

namespace App\Controller;

use App\Repository\CarteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    private $carteRepository;

    public function __construct(CarteRepository $carteRepository)
    {
        $this->carteRepository = $carteRepository;
    }

    /**
     * @Route("/cartes", name="add_carte", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $titre = $data['titre'];
        $descrption = $data['description'];
        $prix = $data['prix'];
        $estPublie = $data['est_publie'];
        $image = $data['image'];
        $categorie = $data['categorie'];

        if (empty($titre)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->carteRepository->save($titre, $descrption, $prix, $estPublie, $image, $categorie);

        return new JsonResponse(['status' => 'Carte created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/cartes/{id}", name="get_one_carte", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $carte = $this->carteRepository->findOneBy(['id' => $id]);

        if($carte == null) {
            return new JsonResponse(['status' => 'Carte not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $carte->getId(),
            'titre' => $carte->getTitre(),
            'description' => $carte->getDescription(),
            'prix' => $carte->getPrix(),
            'est_publie' => $carte->isEstPublie(),
            'image' => $carte->getImage(),
            'categorie' => $carte->getCategorie(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/cartes", name="get_all_cartes", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $cartes = $this->carteRepository->findAll();
        $data = [];

        foreach ($cartes as $carte) {
            $data[] = [
                'id' => $carte->getId(),
                'titre' => $carte->getTitre(),
                'description' => $carte->getDescription(),
                'prix' => $carte->getPrix(),
                'est_publie' => $carte->isEstPublie(),
                'image' => $carte->getImage(),
                'categorie' => $carte->getCategorie(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/cartes/{id}", name="update_carte", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $carte = $this->carteRepository->findOneBy(['id' => $id]);

        if($carte == null) {
            return new JsonResponse(['status' => 'Carte not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['titre']) ? true : $carte->setTitre($data['titre']);
        empty($data['description']) ? true : $carte->setDescription($data['description']);
        empty($data['prix']) ? true : $carte->setPrix($data['prix']);
        empty($data['est_publie']) ? true : $carte->setEstPublie($data['est_publie']);
        empty($data['image']) ? true : $carte->setImage($data['image']);
        empty($data['categorie']) ? true : $carte->setCategorie($data['categorie']);

        $updatedCarte = $this->carteRepository->update($carte);

        return new JsonResponse($updatedCarte, Response::HTTP_OK);
    }

    /**
     * @Route("/cartes/{id}", name="delete_carte", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $carte = $this->carteRepository->findOneBy(['id' => $id]);

        if($carte == null) {
            return new JsonResponse(['status' => 'Carte not found!'], Response::HTTP_NOT_FOUND);
        }

        $this->carteRepository->remove($carte);

        return new JsonResponse(['status' => 'Carte deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/cartes/{id}/publier", name="published_one_carte", methods={"GET"})
     */
    public function publish($id): JsonResponse
    {
        $carte = $this->carteRepository->findOneBy(['id' => $id]);

        if($carte == null) {
            return new JsonResponse(['status' => 'Carte not found!'], Response::HTTP_NOT_FOUND);
        }

        $carte->setEstPublie(true);

        $updatedCarte = $this->carteRepository->update($carte);

        return new JsonResponse($updatedCarte, Response::HTTP_OK);
    }

    /**
     * @Route("/cartes/{id}/desactiver", name="desactived_one_carte", methods={"GET"})
     */
    public function desactivate($id): JsonResponse
    {
        $carte = $this->carteRepository->findOneBy(['id' => $id]);

        if($carte == null) {
            return new JsonResponse(['status' => 'Carte not found!'], Response::HTTP_NOT_FOUND);
        }

        $carte->setEstPublie(false);

        $updatedCarte = $this->carteRepository->update($carte);

        return new JsonResponse($updatedCarte, Response::HTTP_OK);
    }
}
