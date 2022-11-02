<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class UserService implements IPaginationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TagAwareCacheInterface $cache,
        private readonly EntityManagerInterface $em,
        private readonly SerializerInterface $serializer,
        private readonly Security $security
    )
    {
    }

    public function findAllWithPagination($page, $limit)
    {
        return $this->userRepository->findAllWithPagination($page, $limit);
    }

    public function find(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function countAll(?UserInterface $client = null)
    {
        return $this->userRepository->countAll($client);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function cache(Request $request)
    {
        $page = (int) $request->get(key:'page', default: 1);
        $limit = (int) $request->get(key: 'limit', default: 3);

        $idCache = "getAllUsers-".$page."-".$limit;

        return $this->cache->get($idCache, function (ItemInterface $item) use ($page, $limit) {
            echo("NOT IN CACHE YET\n");
            $item->tag("usersCache");
            return $this->findAllWithPagination($page, $limit);
        });

    }

    public function delete(User $user)
    {
        $this->cache->invalidateTags(["usersCache"]);
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function create(Request $request): User
    {
        $this->cache->invalidateTags(["usersCache"]);
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $this->setCreateAtOnCreate($user);
        $this->attachToClient($user);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * @throws Exception
     */
    private function setCreateAtOnCreate(User $user): void
    {
        $user->setCreatedAt(new DateTimeImmutable("now", new DateTimeZone('Europe/Paris')));
    }

    private function attachToClient(User $user): void
    {
        $client = $this->security->getUser();
        $user->setClient($client);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function update(Request $request, User $currentUser): bool
    {
        $this->cache->invalidateTags(["usersCache"]);
        $newUser = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $currentUser->setUsername($newUser->getUsername() ?? $currentUser->getUsername());
        $currentUser->setEmail($newUser->getEmail() ?? $currentUser->getEmail());
        $this->em->persist($currentUser);
        $this->em->flush();
        return true;
    }
}