<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * @Route("/images", name="add_image", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $titre = $data['titre'];
        $path = $data['path'];
        

        if (empty($titre)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->imageRepository->save($titre, $path);

        return new JsonResponse(['status' => 'Image created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/images/{id}", name="get_one_image", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $image = $this->imageRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $image->getId(),
            'titre' => $image->getTitre(),
            'path'=>$image->getPath(),
            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/images", name="get_all_images", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $images = $this->imageRepository->findAll();
        $data = [];

        foreach ($images as $image) {
            $data[] = [
            'id' => $image->getId(),
            'titre' => $image->getTitre(),
            'path'=>$image->getPath(),
            
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/images/{id}", name="update_image", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $image = $this->imageRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['titre']) ? true : $image->setTitre($data['titre']);
        empty($data['path']) ? true : $image->setPath($data['path']);
        

        $updatedImage = $this->imageRepository->update($image);

        return new JsonResponse($updatedImage, Response::HTTP_OK);
    }

    /**
     * @Route("/images/{id}", name="delete_image", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $image = $this->imageRepository->findOneBy(['id' => $id]);

        $this->imageRepository->remove($image);

        return new JsonResponse(['status' => 'Image deleted'], Response::HTTP_NO_CONTENT);
    }
}
