<?php

namespace App\Services;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ProductService implements IPaginationService
{
    public function __construct(
        private readonly ProductRepository      $productRepository,
        private readonly TagAwareCacheInterface $cache,
    )
    {
    }

    public function findAllWithPagination($page, $limit)
    {
        return $this->productRepository->findAllWithPagination($page, $limit);
    }

    public function find(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countAll(?UserInterface $client = null)
    {
        return $this->productRepository->countAll($client);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function cache(Request $request)
    {
        $page = (int) $request->get(key: 'page', default: 1);
        $limit = (int) $request->get(key: 'limit', default: 3);

        $idCache = "getAllProducts-".$page."-".$limit;

        return $this->cache->get($idCache, function (ItemInterface $item) use ($page, $limit) {
            $item->tag("productsCache");
            return $this->findAllWithPagination($page, $limit);
        });
    }

}
