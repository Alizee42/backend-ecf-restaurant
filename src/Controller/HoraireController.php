<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HoraireController extends AbstractController
{
    private $horaireRepository;

    public function __construct(HoraireRepository $horaireRepository)
    {
        $this->horaireRepository = $horaireRepository;
    }

    /**
     * @Route("/horaires", name="add_horaire", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $ouverture = $data['ouverture'];
        $fermeture = $data['fermeture'];
        $jour = $data['jour'];
        $moment=$data['moment'];
        
        if (empty($ouverture)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->horaireRepository->save($ouverture, $fermeture, $jour,$moment);

        return new JsonResponse(['status' => 'Horaire created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/Horaires/{id}", name="get_one_horaire", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $horaire = $this->horaireRepository->findOneBy(['id' => $id]);

        if($horaire == null) {
            return new JsonResponse(['status' => 'Horaire not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $horaire->getId(),
            'ouverture' => $horaire->getOuverture(),
            'fermeture'=>$horaire->getFermeture(),
            'jour'=>$horaire->getJour(),
            'moment'=>$horaire->getMoment(),

            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/horaires", name="get_all_horaire", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $horaires = $this->horaireRepository->findAll();
        $data = [];

        foreach ($horaires as $horaire) {
            $data[] = [
                'id' => $horaire->getId(),
                'ouverture' => $horaire->getOuverture(),
                'fermeture'=>$horaire->getFermeture(),
                'jour'=>$horaire->getJour(),
                'moment'=>$horaire->getMoment(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/horaires/{id}", name="update_horaire", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $horaire = $this->horaireRepository->findOneBy(['id' => $id]);

        if($horaire == null) {
            return new JsonResponse(['status' => 'Horaire not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['ouverture']) ? true : $horaire->setOuverture($data['ouverture']);
        empty($data['fermeture']) ? true : $horaire->setFermeture($data['fermeture']);
        empty($data['jour']) ? true : $horaire->setJour($data['jour']);
        empty($data['moment']) ? true : $horaire->setMoment($data['moment']);
        

        $updatedHoraire = $this->horaireRepository->update($horaire);

        return new JsonResponse($updatedHoraire, Response::HTTP_OK);
    }

    /**
     * @Route("/horaires/{id}", name="delete_horaire", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $horaire = $this->horaireRepository->findOneBy(['id' => $id]);

        if($horaire == null) {
            return new JsonResponse(['status' => 'Horaire not found!'], Response::HTTP_NOT_FOUND);
        }

        $this->horaireRepository->remove($horaire);

        return new JsonResponse(['status' => 'Horaire deleted'], Response::HTTP_NO_CONTENT);
    }
}
