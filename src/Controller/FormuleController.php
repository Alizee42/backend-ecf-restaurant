<?php

namespace App\Controller;

use App\Repository\FormuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FormuleController extends AbstractController
{
    private $formuleRepository;

    public function __construct(FormuleRepository $formuleRepository)
    {
        $this->formuleRepository = $formuleRepository;
    }

    /**
     * @Route("/formules", name="add_formule", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $prix = $data['prix'];
        $description = $data['description'];
        

        if (empty($prix)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->formuleRepository->save($prix, $description );

        return new JsonResponse(['status' => 'Formule created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/formules/{id}", name="get_one_formule", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $formule = $this->formuleRepository->findOneBy(['id' => $id]);

        if($formule == null) {
            return new JsonResponse(['status' => 'Formule not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $formule->getId(),
            'prix' => $formule->getPrix(),
            'description'=>$formule->getDescription(),
            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/formules", name="get_all_formules", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $formules = $this->formuleRepository->findAll();
        $data = [];

        foreach ($formules as $formule) {
            $data[] = [
                'id' => $formule->getId(),
                'prix' => $formule->getPrix(),
                'description'=>$formule->getDescription(),
                
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/formules/{id}", name="update_formule", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $formule = $this->formuleRepository->findOneBy(['id' => $id]);

        if($formule == null) {
            return new JsonResponse(['status' => 'Formule not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['prix']) ? true : $formule->setPrix ($data['prix']);
        empty($data['description']) ? true : $formule->setDescription($data['description']);
        
        $updatedFormule = $this->formuleRepository->update($formule);

        return new JsonResponse($updatedFormule, Response::HTTP_OK);
    }

    /**
     * @Route("/formules/{id}", name="delete_formule", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $formule = $this->formuleRepository->findOneBy(['id' => $id]);

        if($formule == null) {
            return new JsonResponse(['status' => 'Formule not found!'], Response::HTTP_NOT_FOUND);
        }

        $this->formuleRepository->remove($formule);

        return new JsonResponse(['status' => 'Formule deleted'], Response::HTTP_NO_CONTENT);
    }
}
