<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
        $languages = ['PHP', 'JavaScript', 'Swift', 'HTML', '(S)CSS/SASS', 'TypeScript', 'Bash', 'SQL'];
        $technologies = ['ReactJS', 'Angular', 'SwiftUI', 'NodeJS', 'ExpressJS', 'MariaDB', 'TailwindCSS'];

        return $this->render('vinyl/homepage.html.twig', []);
    }
}
