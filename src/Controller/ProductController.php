<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'app_products', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $productsData = $productRepository->findAll();
        $context = SerializationContext::create()->setGroups(['getProducts']);
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