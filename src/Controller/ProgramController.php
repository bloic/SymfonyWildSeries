<?php


namespace App\Controller;

use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/programs", name="program_")
 */

class ProgramController extends AbstractController
{

    /**
     * @Route("/index", name="index")
     * @param ProgramRepository $programRepository
     * @return Response
     */
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render(
            'program/index.html.twig', ['programs' => $programs
            ]);
    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"}, methods={"GET"}, name="show")
     * @param ProgramRepository $programRepository
     * @param SeasonRepository $seasonRepository
     * @param int $id
     * @return Response
     */
    public function show(ProgramRepository $programRepository,SeasonRepository $seasonRepository, int $id): Response
    {
        $programs = $programRepository->findOneBy(['id' => $id]);
        if (!$programs) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        $seasons = $seasonRepository->findBy(['program'=>$id]);
        return $this->render('program/show.html.twig', [
            'programs' => $programs,
            'seasons' =>$seasons
        ]);
    }

    /**
     * @Route("/{programId}/season/{seasonId}", methods={"GET"}, name="season_show")
     * @param ProgramRepository $programRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     * @param int $programId
     * @param int $seasonId
     * @return Response
     */
    public function showSeason(ProgramRepository $programRepository,
                               SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository,
         int $programId, int $seasonId): Response
    {
        $program = $programRepository->findOneBy(['id'=>$programId]);
        $seasons = $seasonRepository->findBy(['id'=> $seasonId]);
        $episodes = $episodeRepository->findBy(['season'=>$seasonId]);
        return $this->render('program/season-show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'episodes' => $episodes
        ]);

    }
}