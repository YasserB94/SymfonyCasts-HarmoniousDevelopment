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

        return $this->render('vinyl/homepage.html.twig', ['name' => 'Yasser', 'tech' => 'Symfony 6', 'languages' => $languages, 'technologies' => $technologies]);
    }
    //Instead of using this extra route the parameter in the category route is optional now
//    #[Route('/browse')]
//    public function browse(): Response
//    {
//        return new Response('Nothing to browse trough...... yet!');
//    }

    #[Route('/browse/{category}')]
    public function browseByCategory(string $category = null): Response
    {
        //Replacing any dashes with spaces
        //str_replace('-', ' ', $category);
        if ($category) {
            //u is a symfony library that helps with string transformations - in this case we uppercase any letters like in a title
            $title = u(str_replace('-', ' ', $category))->title(true);
            return new Response('Nothing to browse in the category: ' . $title
            );
        }
        return new Response('Nothing to browse trough...... yet!');
    }
}