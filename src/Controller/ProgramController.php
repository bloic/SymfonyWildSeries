<?php


namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @param Program $id
     * @return Response
     */
    public function show(ProgramRepository $programRepository,SeasonRepository $seasonRepository, Program $id): Response
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
            'seasons' => $seasons
        ]);
    }

    /**
     * @Route("/{program}/season/{season}", methods={"GET"}, name="season_show")
     * @param EpisodeRepository $episodeRepository
     * @param Program $program
     * @param Season $season
     * @return Response
     */
    public function showSeason( EpisodeRepository $episodeRepository,
         Program $program, Season $season): Response
    {
        $episodes = $episodeRepository->findBy(['season'=>$season]);
        return $this->render('program/season-show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }

    /**
     * @Route("/{program}/season/{season}/episode/{episode}", methods={"GET"}, name="episode_show")
     * @param Program $program
     * @param Season $season
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(
                                Program $program,
                                Season $season,
                                Episode $episode): Response
    {
        return $this->render('program/episode-show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }


}