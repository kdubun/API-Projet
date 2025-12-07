<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiTaskController extends AbstractController
{
    public function index(TaskRepository $taskRepository): JsonResponse
    {
        $tasks = $taskRepository->findAll();

        $data = array_map(function (Task $task) {
            return [
                'id' => $task->getId(),
                // champs de ton entité : titre / description / etat
                'title' => $task->getTitre(),
                'description' => $task->getDescription(),
                // si ça plante ici, remplace isEtat() par getEtat()
                'isDone' => method_exists($task, 'isEtat') ? $task->isEtat() : $task->getEtat(),
            ];
        }, $tasks);

        return $this->json($data);
    }

    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $body = json_decode($request->getContent(), true) ?? [];

        $task = new Task();
        // on mappe title -> titre dans l'entité
        $task->setTitre($body['title'] ?? 'Sans titre');
        $task->setDescription($body['description'] ?? null);
        $task->setEtat($body['isDone'] ?? false);

        $em->persist($task);
        $em->flush();

        return $this->json([
            'id' => $task->getId(),
            'message' => 'Task created',
        ], 201);
    }

    public function show(Task $task = null): JsonResponse
    {
        if (!$task) {
            return $this->json(['message' => 'Not found'], 404);
        }

        return $this->json([
            'id' => $task->getId(),
            'title' => $task->getTitre(),
            'description' => $task->getDescription(),
            'isDone' => method_exists($task, 'isEtat') ? $task->isEtat() : $task->getEtat(),
        ]);
    }

    public function update(Task $task = null, Request $request, EntityManagerInterface $em): JsonResponse
    {
        if (!$task) {
            return $this->json(['message' => 'Not found'], 404);
        }

        $body = json_decode($request->getContent(), true) ?? [];

        if (isset($body['title'])) {
            $task->setTitre($body['title']);
        }
        if (array_key_exists('description', $body)) {
            $task->setDescription($body['description']);
        }
        if (isset($body['isDone'])) {
            $task->setEtat($body['isDone']);
        }

        $em->flush();

        return $this->json(['message' => 'Task updated']);
    }

    public function delete(Task $task = null, EntityManagerInterface $em): JsonResponse
    {
        if (!$task) {
            return $this->json(['message' => 'Not found'], 404);
        }

        $em->remove($task);
        $em->flush();

        return $this->json(['message' => 'Task deleted']);
    }
}
