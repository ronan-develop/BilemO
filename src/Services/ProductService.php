<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductService implements PaginationServiceInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function findAllWithPagination(int $offset, int $limit, ?UserInterface $client = null)
    {
        return $this->productRepository->findAllWithPagination($offset, $limit, $client);
    }
    public function countAll(?UserInterface $client = null)
    {
        return $this->productRepository->countAll($client);
    }

    public function find(int $id): ?\App\Entity\Product
    {
        return $this->productRepository->find($id);
    }
}
