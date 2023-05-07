<?php

namespace App\Controller;

use App\Dto\Request\CreateBlogPostRequestDto;
use App\Dto\Request\UpdateBlogPostRequestDto;
use App\Service\BlogPostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
    public function addBlogPost(CreateBlogPostRequestDto $createBlogPostRequestDto): JsonResponse
    {

        if (!$createBlogPostRequestDto->validate())
            return $this->json(data: ["message" => "Missing parameter"], status: 422);

        $blogPost = $this->blogPostService->addBlogPost($createBlogPostRequestDto);

        return $this->json(data: $blogPost, status: 201);
    }

    /**
     * @Route(path="", name="update", methods={"PUT"})
     */

    public function updateBlogPost(UpdateBlogPostRequestDto $updateBlogPostRequestDto): JsonResponse
    {

        if (!$updateBlogPostRequestDto->validate())
            return $this->json(data: ['message' => "missing parameter"], status: 422);

        $updatedBlogPost = $this->blogPostService->updateBlogPost($updateBlogPostRequestDto);

        return $this->json(data: $updatedBlogPost, status: 200);
    }
}