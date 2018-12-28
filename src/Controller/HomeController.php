<?php

namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @return Response
     */

    public function index(PropertyRepository $repository): Response
    {
        $properties = $repository->findLatest();

        return $this->render('home/home.html.twig', [
            'properties' => $properties,
        ]);
    }
}
