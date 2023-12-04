<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function indexProgram(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
    
        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/program/', name: 'program_index')]
      public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs
         ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'program_show')]
    public function show(int $id, ProgramRepository $programRepository):Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

     #[Route("/program/{id}", name: 'program_show')]
    public function showEpisode(int $id, ProgramRepository $episodRepository): Response
    {
        $episod = $episodRepository->find($id);

        return $this->render('program/show.html.twig', ['episod' => $episod]);
    }

    #[Route("/program/{programId}/season/{seasonId}", name: 'program_season_show')]
    public function showSeason(int $id, ProgramRepository $programId, ProgramRepository $seasonId): Response
    {
        $programSeason = $programId->find($id);
        $season = $seasonId->find($id);

        return $this->render('program/season_show.html.twig', ['programSeason' => $programSeason, 'season' => $season]);
    }
}
