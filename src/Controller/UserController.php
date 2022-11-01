<?php

namespace App\Controller;

use App\Services\UserService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    #[Route('/api/users', name: 'app_user', methods: ['GET'])]
    public function getAllUSers(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getClients']);

        $usersData = $this->userService->cache($request);

        $json = $serializer->serialize($usersData, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
