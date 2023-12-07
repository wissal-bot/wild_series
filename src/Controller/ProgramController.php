<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{

    #[Route('/', name: 'program_index')]
    public function indexProgram(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
    
        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/show/{id}', requirements:['id'=>'\d+'], name: 'program_show')]
    public function show(int $id, ProgramRepository $programRepository):Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route("/program/{programId}/season/{seasonId}", name: 'program_season_show')]
    public function showSeason(ProgramRepository $programRepository, int $programId, SeasonRepository $seasonRepository, int $seasonId, EpisodeRepository $episodeRepository): Response
    {
        $program = $programRepository->findOneById($programId);
        $season = $seasonRepository->findOneById($seasonId);
        $episodesBySeason = $episodeRepository->findBySeason($season);

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodesBySeason]);
    }

    #[Route("/program/{programId}/season/{seasonId}/episode/{episodeId}", name: 'program_season_episode_show')]
    public function showAll(ProgramRepository $programRepository, int $programId, SeasonRepository $seasonRepository, int $seasonId, EpisodeRepository $episodeRepository, int $episodeId): Response
    {
        $program = $programRepository->findOneById($programId);
        $season = $seasonRepository->findOneById($seasonId);
        $episodes = $episodeRepository->findOneById($episodeId);

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }
}
