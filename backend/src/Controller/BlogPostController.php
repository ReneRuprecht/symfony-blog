<?php

namespace App\Controller;

use App\Dto\Request\CreateBlogPostDto;
use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
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
    public function __construct(private BlogPostRepository $blogPostRepository, private SerializerInterface $serializer)
    {
    }

    /**
     * @Route(path="", name="all_blogs", methods={"GET"})
     */
    public function all(): JsonResponse
    {
        $blogPosts = $this->blogPostRepository->findAll();
        return $this->json(data: [
            'blog_posts' => $blogPosts
        ], status: 200);
    }

    /**
     * @Route(path="", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {

        try {
            $createBlogPostDto = $this->serializer->deserialize($request->getContent(), CreateBlogPostDto::class, 'json');
        } catch (MissingConstructorArgumentsException) {
            return $this->json(data: ["message" => "Missing parameter"], status: 422);
        }

        $blogPost = new BlogPost();
        $blogPost->setTitle($createBlogPostDto->getTitle());
        $blogPost->setContent($createBlogPostDto->getContent());

        $this->blogPostRepository->save($blogPost, true);

        return $this->json(data: $blogPost, status: 201);
    }
}
