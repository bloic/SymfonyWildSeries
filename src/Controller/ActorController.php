<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actors", name="actors_")
 */

class ActorController extends AbstractController
{
    /**
     * @Route("/", name="actor")
     * @param ActorRepository $actorRepository
     * @return Response
     */
    public function index(ActorRepository $actorRepository): Response
    {
        $actors = $actorRepository->findAll();
        return $this->render('actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    /**
     * @Route ("/{actor}", name = "show")
     * @param Actor $actor
     * @return Response
     */
    public function show(Actor $actor): Response
    {
        $programs = $actor->getPrograms();
        return $this->render('actor/show.html.twig', [
            'actor'=> $actor,
            'programs'=>$programs
        ]);
    }
}
