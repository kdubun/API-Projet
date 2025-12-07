<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskFrontController extends AbstractController
{
    #[Route('/tasks', name: 'tasks_front')]
    public function index(): Response
    {
        return $this->render('tasks/index.html.twig');
    }
}
