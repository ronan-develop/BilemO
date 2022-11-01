<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Services\ProductService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly TagAwareCacheInterface $cache
    )
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/products', name: 'app_products', methods: ['GET'])]
    public function getAllProducts(SerializerInterface $serializer, Request $request, ProductRepository $productRepository): JsonResponse
    {
        $page = (int) $request->get(key: 'page', default: 1);
        $limit = (int) $request->get(key: 'limit', default: 3);

        $context = SerializationContext::create()->setGroups(['getProducts']);
        $idCache = "getAllProducts-".$page."-".$limit;

        $productsData = $this->cache->get($idCache, function (ItemInterface $item) use ($productRepository, $page, $limit) {
            echo("NOT IN CACHE YET\n");
            $item->tag("productsCache");
            return $this->productService->findAllWithPagination($page, $limit);
        });

        $json = $serializer->serialize($productsData, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/api/products/{id}', name: 'app_product', methods: ['GET'])]
    public function getOneProduct(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getProducts']);
        $product = $serializer->serialize($product, 'json', $context);
        return new JsonResponse($product, Response::HTTP_OK, ['accept'=>'json'], true);
    }
}