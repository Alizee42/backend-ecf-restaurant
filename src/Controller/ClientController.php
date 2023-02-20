<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @Route("/clients", name="add_client", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];
        $prenoms = $data['prenoms'];
        $telephone = $data['telephone'];
        $nombreDeConvive = $data['nombreDeConvive'];
        $allergies = $data['allergies'];

        if (empty($nom)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->clientRepository->save($nom, $prenoms, $telephone, $nombreDeConvive, $allergies);

        return new JsonResponse(['status' => 'Client created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/clients/{id}", name="get_one_client", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $client = $this->clientRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $client->getId(),
            'nom' => $client->getNom(),
            'prenoms'=>$client->getPrenoms(),
            'telephone'=>$client->getTelephone(),
            'nombreDeConvive'=>$client->getNombreDeConvive(),
            'allergies'=>$client->getAllergies(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/clients", name="get_all_clients", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $clients = $this->clientRepository->findAll();
        $data = [];

        foreach ($clients as $client) {
            $data[] = [
                'id' => $client->getId(),
                'nom' => $client->getNom(),
                'prenoms'=>$client->getPrenoms(),
                'telephone'=>$client->getTelephone(),
                'nombreDeConvive'=>$client->getNombreDeConvive(),
                'allergies'=>$client->getAllergies(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/clients/{id}", name="update_client", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $client = $this->clientRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['nom']) ? true : $client->setNom($data['nom']);
        empty($data['prenoms']) ? true : $client->setPrenoms($data['prenoms']);
        empty($data['telephone']) ? true : $client->setTelephone($data['telephone']);
        empty($data['nombreDeConvive']) ? true : $client->setNombreDeConvive($data['nombreDeConvive']);
        empty($data['allergies']) ? true : $client->setAllergies($data['allergies']);

        $updatedClient = $this->clientRepository->update($client);

        return new JsonResponse($updatedClient, Response::HTTP_OK);
    }

    /**
     * @Route("/clients/{id}", name="delete_client", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $client = $this->clientRepository->findOneBy(['id' => $id]);

        $this->clientRepository->remove($client);

        return new JsonResponse(['status' => 'Client deleted'], Response::HTTP_NO_CONTENT);
    }
}
