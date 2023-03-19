<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @Route("/reservations", name="add_reservation", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];
        $numero = $data['numero'];
        $date = $data['date'];
        $heurePrevu = $data['heurePrevu'];
        $nombreConvive = $data['nombreConvive'];
        $allergie = $data['allergie'];


        if (empty($numero)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->reservationRepository->save($nom, $numero, $date, $heurePrevu, $nombreConvive, $allergie);

        return new JsonResponse(['status' => 'Reservation created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/reservations/{id}", name="get_one_reservation", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $reservation = $this->reservationRepository->findOneBy(['id' => $id]);

        if($reservation == null) {
            return new JsonResponse(['status' => 'Reservation not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $reservation->getId(),
            'nom' => $reservation->getNom(),
            'numero' => $reservation->getNumero(),
            'date'=>$reservation->getDate(),
            'heurePrevu'=>$reservation->getHeurePrevu(),
            'nombreConvive'=>$reservation->getNombreConvive(),
            'allergie'=>$reservation->getAllergie(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/reservations", name="get_all_reservations", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $reservations = $this->reservationRepository->findAll();
        $data = [];

        foreach ($reservations as $reservation) {
            $data[] = [
                'id' => $reservation->getId(),
                'nom'=> $reservation->getNom(),
                'numero' => $reservation->getNumero(),
                'date'=>$reservation->getDate(),
                'heurePrevu'=>$reservation->getHeurePrevu(),
                'nombreConvive'=>$reservation->getNombreConvive(),
                'allergie'=>$reservation->getAllergie(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/reservations/{id}", name="update_reservation", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $reservation = $this->reservationRepository->findOneBy(['id' => $id]);

        if($reservation == null) {
            return new JsonResponse(['status' => 'Reservation not found!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['nom']) ? true : $reservation->setNom($data['nom']);
        empty($data['numero']) ? true : $reservation->setNumero($data['numero']);
        empty($data['date']) ? true : $reservation->setDate($data['date']);
        empty($data['heurePrevu']) ? true : $reservation->setHeurePrevu($data['heurePrevu']);
        empty($data['nombreConvive']) ? true : $reservation->setNombreConvive($data['nombreConvive']);
        empty($data['allergie']) ? true : $reservation->setAllergie($data['allergie']);

        $updatedReservation = $this->reservationRepository->update($reservation);

        return new JsonResponse($updatedReservation, Response::HTTP_OK);
    }

    /**
     * @Route("/reservations/{id}", name="delete_reservation", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $reservation = $this->reservationRepository->findOneBy(['id' => $id]);

        if($reservation == null) {
            return new JsonResponse(['status' => 'Reservation not found!'], Response::HTTP_NOT_FOUND);
        }

        $this->reservationRepository->remove($reservation);

        return new JsonResponse(['status' => 'Reservation deleted'], Response::HTTP_NO_CONTENT);
    }
}
