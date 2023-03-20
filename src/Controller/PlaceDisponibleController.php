<?php

namespace App\Controller;

use App\Repository\PlaceDisponibleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PlaceDisponibleController extends AbstractController
{
    private $placeDisponibleRepository;

    public function __construct(PlaceDisponibleRepository $placeDisponibleRepository)
    {
        $this->placeDisponibleRepository = $placeDisponibleRepository;
    }

    /**
     * @Route("/places", name="add_place", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nombre = $data['nombre'];
        $valeurParDefaut = $data['valeur_par_defaut'];
        

        if (empty($nombre)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->placeDisponibleRepository->save($nombre, $valeurParDefaut);

        return new JsonResponse(['status' => 'Place disponible created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/places/{id}", name="get_one_place", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $place = $this->placeDisponibleRepository->findOneBy(['id' => $id]);

        if($place == null) {
            return new JsonResponse(['status' => 'Place not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $place->getId(),
            'nombre' => $place->getNombre(),
            'valeur_par_defaut' => $place->getValeurParDefaut(),
            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/places/disponible", name="get_place_disponible", methods={"GET"})
     */
    public function getPlaceDisponible(): JsonResponse
    {
        $place = $this->placeDisponibleRepository->findOneBy(['valeurParDefaut' => 100]);

        if($place == null) {
            return new JsonResponse(['status' => 'Place not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $place->getId(),
            'nombre' => $place->getNombre(),
            'valeur_par_defaut' => $place->getValeurParDefaut(),
            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/places", name="get_all_places", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $places = $this->placeDisponibleRepository->findAll();
        $data = [];

        foreach ($places as $place) {
            $data[] = [
                'id' => $place->getId(),
                'nombre' => $place->getNombre(),
                'valeur_par_defaut' => $place->getValeurParDefaut(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/places/{id}", name="update_place", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $place = $this->placeDisponibleRepository->findOneBy(['id' => $id]);

        if($place == null) {
            return new JsonResponse(['status' => 'Place not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['nombre']) ? true : $place->setNombre($data['nombre']);
        empty($data['valeur_par_defaut']) ? true : $place->setValeurParDefaut($data['valeur_par_defaut']);
        

        $updatedPlace = $this->placeDisponibleRepository->update($place);

        return new JsonResponse($updatedPlace, Response::HTTP_OK);
    }

    /**
     * @Route("/reservation/valider", name="validate_place", methods={"PUT"})
     */
    public function validate(): JsonResponse
    {
        $place = $this->placeDisponibleRepository->findOneBy(['valeurParDefaut' => 100]);

        if($place == null) {
            return new JsonResponse(['status' => 'Place not found!'], Response::HTTP_NOT_FOUND);
        }
        
        $nombrePlace = $place->getNombre() - 1;
        $place->setNombre($nombrePlace);
        
        $updatedPlace = $this->placeDisponibleRepository->update($place);

        return new JsonResponse($updatedPlace, Response::HTTP_OK);
    }

    /**
     * @Route("/reservation/refuser", name="refused_place", methods={"PUT"})
     */
    public function refused(): JsonResponse
    {
        $place = $this->placeDisponibleRepository->findOneBy(['valeurParDefaut' => 100]);

        if($place == null) {
            return new JsonResponse(['status' => 'Place not found!'], Response::HTTP_NOT_FOUND);
        }
        
        $nombrePlace = $place->getNombre() + 1;
        $place->setNombre($nombrePlace);
        
        $updatedPlace = $this->placeDisponibleRepository->update($place);

        return new JsonResponse($updatedPlace, Response::HTTP_OK);
    }

    /**
     * @Route("/places/{id}", name="delete_place", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $place = $this->placeDisponibleRepository->findOneBy(['id' => $id]);

        if($place == null) {
            return new JsonResponse(['status' => 'Place not found!'], Response::HTTP_NOT_FOUND);
        }

        $this->placeDisponibleRepository->remove($place);

        return new JsonResponse(['status' => 'Place disponible deleted'], Response::HTTP_NO_CONTENT);
    }
}
