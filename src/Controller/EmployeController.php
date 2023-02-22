<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    private $employeRepository;

    public function __construct(EmployeRepository $employeRepository)
    {
        $this->employeRepository = $employeRepository;
    }

    /**
     * @Route("/employes", name="add_employe", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];
        $prenoms = $data['prenoms'];
        $adresse = $data['adresse'];
        $email = $data['email'];
        $telephone = $data['telephone'];

        if (empty($nom)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->employeRepository->save($nom, $prenoms, $adresse, $email,$telephone);

        return new JsonResponse(['status' => 'Employe created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/employes/{id}", name="get_one_employe", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $employe = $this->employeRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $employe->getId(),
            'nom' => $employe->getNom(),
            'prenoms' => $employe->getPrenoms(),
            'adresse' => $employe->getAdresse(),
            'email' => $employe->getEmail(),
            'telephone' => $employe->getTelephone(),
            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/employes", name="get_all_employes", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $employes = $this->employeRepository->findAll();
        $data = [];

        foreach ($employes as $employe) {
            $data[] = [
                'id' => $employe->getId(),
                'nom' => $employe->getNom(),
                'prenoms' => $employe->getPrenoms(),
                'adresse' => $employe->getAdresse(),
                'email' => $employe->getEmail(),
                'telephone' => $employe->getTelephone(),
              
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/employes/{id}", name="update_employe", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $employe = $this->employeRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['nom']) ? true : $employe->setNom($data['nom']);
        empty($data['prenoms']) ? true : $employe->setPrenoms($data['prenoms']);
        empty($data['adresse']) ? true : $employe->setAdresse($data['adresse']);
        empty($data['email']) ? true : $employe->setEmail($data['email']);
        empty($data['telephone']) ? true : $employe->setTelephone($data['telephone']);

        $updatedEmploye = $this->employeRepository->update($employe);

        return new JsonResponse($updatedEmploye, Response::HTTP_OK);
    }

    /**
     * @Route("/employes/{id}", name="delete_employe", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $employe = $this->employeRepository->findOneBy(['id' => $id]);

        $this->employeRepository->remove($employe);

        return new JsonResponse(['status' => 'Employe deleted'], Response::HTTP_NO_CONTENT);
    }
}