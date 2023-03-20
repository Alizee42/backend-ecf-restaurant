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

        $ouvertureMatin = $data['ouverture_matin'];
        $fermetureMatin = $data['fermeture_matin'];
        $ouvertureSoir = $data['ouverture_soir'];
        $fermetureSoir = $data['fermeture_soir'];
        $jour = $data['jour'];
       
        
        if (empty($jour)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->horaireRepository->save($ouvertureMatin, $fermetureMatin, $ouvertureSoir, $fermetureSoir, $jour);

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
            'jour'=>$horaire->getJour(),
            'ouverture_matin'=>$horaire->getOuvertureMatin(),
            'fermeture_matin'=>$horaire->getFermetureMatin(),
            'ouverture_soir'=>$horaire->getOuvertureSoir(),
            'fermeture_soir'=>$horaire->getFermetureSoir(),
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
                'jour'=>$horaire->getJour(),
                'ouverture_matin'=>$horaire->getOuvertureMatin(),
                'fermeture_matin'=>$horaire->getFermetureMatin(),
                'ouverture_soir'=>$horaire->getOuvertureSoir(),
                'fermeture_soir'=>$horaire->getFermetureSoir(),
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
        empty($data['jour']) ? true : $horaire->setJour($data['jour']);
        empty($data['ouverture_matin']) ? true : $horaire->setOuvertureMatin($data['ouverture_matin']);
        empty($data['fermeture_matin']) ? true : $horaire->setFermetureMatin($data['fermeture_matin']);
        empty($data['ouverture_soir']) ? true : $horaire->setOuvertureSoir($data['ouverture_soir']);
        empty($data['fermeture_soir']) ? true : $horaire->setFermetureSoir($data['fermeture_soir']);
        
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
