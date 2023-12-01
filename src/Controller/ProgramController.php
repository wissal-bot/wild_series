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
      public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
         ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    public function show(int $id, ProgramRepository $programRepository):Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }
}