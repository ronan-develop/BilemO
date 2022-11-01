<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/api/users/{id}', name: 'app_user_details', methods: ['GET'])]
    public function getOneUser(User $user, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getClients']);
        $user = $this->userService->find($request->get('id'));
        $json = $serializer->serialize($user, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/users/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function deleteOneUser(User $user, EntityManagerInterface $em): JsonResponse
    {
        $this->userService->delete($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
