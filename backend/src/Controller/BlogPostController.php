<?php

namespace App\Controller;

use App\Dto\Request\CreateBlogPostDto;
use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
        return $this->json([
            'blog_posts' => $blogPosts
        ]);
    }

    /**
     * @Route(path="", name="create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $createBlogPostDto = $this->serializer->deserialize($request->getContent(), CreateBlogPostDto::class, 'json');
        $blogPost = new BlogPost();
        $blogPost->setTitle($createBlogPostDto->getTitle());
        $blogPost->setContent($createBlogPostDto->getContent());

        $this->blogPostRepository->save($blogPost, true);

        return $this->json($blogPost);
    }
}
