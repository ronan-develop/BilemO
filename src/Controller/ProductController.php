<?php

namespace App\Controller;

use App\Entity\Product;
use App\Services\ProductService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService
    )
    {
    }

    /**
     * Method to get all products in catalogue
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    #[Route('/api/products', name: 'app_products', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: "Return all products in the catalogue",
        content: new OA\JsonContent(
        type: 'array',
        items: new OA\Items(ref: new Model(type: Product::class, groups: ['getProducts']))
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
    #[OA\Tag("Products")]
    public function getAllProducts(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getProducts']);

        $productsData = $this->productService->cache($request);

        $json = $serializer->serialize($productsData, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * Method to access product details
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/products/{id}', name: 'app_product_details', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: "Return product by Id",
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Product::class, groups: ['getProducts']))
        )
    )]
    #[OA\Tag("Products")]
    public function getOneProduct(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getProducts']);

        $productData = $this->productService->find($request->get('id'));

        $json = $serializer->serialize($productData, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, ['accept'=>'json'], true);
    }
}