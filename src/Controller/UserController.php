<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Cache\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Attributes as OA;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    /**
     * Method to get all users registered in your account
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    #[Route('/api/users', name: 'app_user', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: "Return all users registered in your account",
        content: new OA\JsonContent(
        type: 'array',
        items: new OA\Items(ref: new Model(type: User::class, groups: ['getUsers']))
    )
    )]
    #[OA\Parameter(
        name: "page",
        description: "Page to get",
        in: "query",
    )]
    #[OA\Parameter(
        name: "limit",
        description: "Products to display",
        in: "query",
    )]
    #[OA\Tag('Users')]
    public function getAllUSers(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getClients']);

        $usersData = $this->userService->cache($request);

        $json = $serializer->serialize($usersData, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/users/{id}', name: 'app_user_details', methods: ['GET'])]
    #[OA\Tag('Users')]
    public function getOneUser(User $user, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('USER_VIEW', $user);

        $context = SerializationContext::create()->setGroups(['getClients']);
        $user = $this->userService->find($request->get('id'));
        $json = $serializer->serialize($user, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/users/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un utilisateur')]
    #[OA\Tag('Users')]
    public function deleteOneUser(User $user, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('USER_DELETE', $user);
        $this->userService->delete($user);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/users/{id}', name: 'app_user_update', methods: ['PUT'])]
    #[OA\Tag('Users')]
    public function updateOneUser(Request $request, User $currentUser, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('USER_EDIT', $currentUser);
        if($this->userService->update($request, $currentUser)){
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        };
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @throws Exception|InvalidArgumentException
     */
    #[Route('/api/users', name: 'app_user_create', methods: ['POST'])]
    #[IsGranted('ROLE_USER', message: 'Vous devez être enregistré')]
    #[OA\Tag('Users')]
    public function createOneUser(Request $request, ValidatorInterface $validator, SerializerInterface $serializer): JsonResponse
    {
        $user = $this->userService->create($request);
        $errors = $validator->validate($user);
        if($errors->count()>0) {
            return $this->json($errors, 400);
        }
        return new JsonResponse($user, Response::HTTP_CREATED);
    }

}