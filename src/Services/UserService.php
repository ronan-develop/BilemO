<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class UserService implements IPaginationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TagAwareCacheInterface $cache,
        private readonly EntityManagerInterface $em
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
        $this->em->remove($user);
        $this->em->flush();
    }
}