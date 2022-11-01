<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
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

    public function find(int $id): ?\App\Entity\Product
    {
        return $this->productRepository->find($id);
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
            echo("NOT IN CACHE YET\n");
            $item->tag("productsCache");
            return $this->findAllWithPagination($page, $limit);
        });
    }

}
