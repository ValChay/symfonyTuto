<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * AdminPropertyController constructor.
     */

    // En le mettant dans le constructeur on aura accès au service dans touted les méthodes
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository,ObjectManager $em )
    {
        $this->em = $em;
        $this->repository = $repository;
    }


    /**
     * @Route("/biens", name="property.index")
     */
    public function index(): Response
    {
       $property = $this->repository->findLatest();
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }

    /**
     * @Route("/biens/{slug}--{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    // en mettant property en paramètre pas besoin decrire le find car dans lannotations il ya {id} qui va le faire a notre place
    public function show(string $slug, Property $property): Response
    {
        if ($property->getSlug() !== $slug){
           return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug'=> $property->getSlug()

            ], 301);
        }

        return $this->render('property/show.html.twig',[
            'current_menu' => 'properties',
            'property' => $property,
        ]);

    }
}
