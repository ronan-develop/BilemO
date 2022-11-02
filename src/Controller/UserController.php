<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un utilisateur')]
    public function deleteOneUser(User $user, EntityManagerInterface $em): JsonResponse
    {
        $this->userService->delete($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/users', name: 'app_user_create', methods: ['POST'])]
    #[IsGranted('ROLE_USER', message: 'Vous devez être enregistré')]
    public function createOneUser(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $user = $this->userService->create($request);
        $errors = $validator->validate($user);
        if($errors->count()>0) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    #[Route('/api/users/{id}', name: 'app_user_update', methods: ['PUT'])]
    public function updateOneUser(Request $request, User $currentUser, EntityManagerInterface $em): JsonResponse
    {
        if($this->userService->update($request, $currentUser)){
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        };
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

}