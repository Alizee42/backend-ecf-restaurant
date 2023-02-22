<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
class MenuController extends AbstractController
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @Route("/menus", name="add_menu", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $titre = $data['titre'];
        
        if (empty($titre)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->menuRepository->save($titre);

        return new JsonResponse(['status' => 'Menu created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/menus/{id}", name="get_one_menu", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $menu = $this->menuRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $menu->getId(),
            'titre' => $menu->getTitre(),
            
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/menus", name="get_all_menus", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $menus = $this->menuRepository->findAll();
        $data = [];

        foreach ($menus as $menu) {
            $data[] = [
                'id' => $menu->getId(),
                'titre' => $menu->getTitre(),
                
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/menus/{id}", name="update_menu", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $menu = $this->menuRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['titre']) ? true : $menu->setTitre($data['titre']);
        

        $updatedMenu = $this->menuRepository->update($menu);

        return new JsonResponse($updatedMenu, Response::HTTP_OK);
    }

    /**
     * @Route("/menus/{id}", name="delete_menu", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $menu = $this->menuRepository->findOneBy(['id' => $id]);

        $this->menuRepository->remove($menu);

        return new JsonResponse(['status' => 'Menu deleted'], Response::HTTP_NO_CONTENT);
    }
}
