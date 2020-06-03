<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_index", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'restaurants' => $restaurantRepository->findTenLast(),
        ]);
    }

    
}
