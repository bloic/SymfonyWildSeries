<?php


namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @param UserRepository $userRepository
     * @param ProgramRepository $programRepository
     * @return Response
     */
    public function index(UserRepository $userRepository, ProgramRepository $programRepository ): Response
    {

        return $this->render('index.html.twig',[
            'users'=>$userRepository->findAll(),
            'programs'=>$programRepository->findBy([] , ['id'=>'DESC'] , 3   )
        ]);
    }
}