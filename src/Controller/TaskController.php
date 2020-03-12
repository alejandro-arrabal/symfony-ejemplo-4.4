<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CollaboratorController
 * @Route("/api/task")
 */
class TaskController extends FOSRestController
{
    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getTask($id, TaskRepository $taskRepository)
    {
        $serializer = $this->get('jms_serializer');
        $task = $taskRepository->find($id);
        $response = $task != null ?
            [
                'code' => 200,
                'error' => $error,
                'data' => $task,
            ] : [
                'code' => 404,
                'message' => 'Entity not found',
            ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Route("/", methods={"PUT"})
     */
    public function postTask(
        Request $request,
        TaskRepository $taskRepository
    ) {
        $title = $request->get('title', "no_name");
        $list_id = $request->get('list_id');
        $serializer = $this->get('jms_serializer');
        $taskRepository->createTask($title, $list_id);
        $response = [
            'code' => 200,
            'message' => 'Entity created'
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Route("/toggle/{id}", methods={"POST"})
     */
    public function toggleTask(
        $id,
        TaskRepository $taskRepository
    ) {
        $serializer = $this->get('jms_serializer');
        $taskRepository->toggleTask($id);
        $response = [
            'code' => 200,
            'message' => 'Entity updated'
        ];
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteTask(
        $id,
        TaskRepository $taskRepository
    ) {
        $serializer = $this->get('jms_serializer');
        $taskRepository->deleteTask($id);
        $response = [
            'code' => 200,
            'message' => 'Entity updated'
        ];
        return new Response($serializer->serialize($response, "json"));
    }
}
