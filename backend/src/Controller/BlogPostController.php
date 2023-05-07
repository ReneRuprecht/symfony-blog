<?php

namespace App\Controller;

use App\Dto\Request\CreateBlogPostRequestDto;
use App\Service\BlogPostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/api/v1/blog")
 */
class BlogPostController extends AbstractController
{
    public function __construct(private BlogPostService $blogPostService)
    {
    }

    /**
     * @Route(path="", name="all_blogs", methods={"GET"})
     */
    public function findAllBlogPosts(): JsonResponse
    {
        return $this->json(data: [
            'blog_posts' => $this->blogPostService->getAllBlogPosts()
        ], status: 200);
    }

    /**
     * @Route(path="", name="create", methods={"POST"})
     */
    public function addBlogPost(Request $request, SerializerInterface $serializer): JsonResponse
    {

        try {
            $createBlogPostDto = $serializer->deserialize($request->getContent(), CreateBlogPostRequestDto::class, 'json');
            $blogPost = $this->blogPostService->addBlogPost($createBlogPostDto);
        } catch (MissingConstructorArgumentsException) {
            return $this->json(data: ["message" => "Missing parameter"], status: 422);
        }


        return $this->json(data: $blogPost, status: 201);
    }
}
