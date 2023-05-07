<?php

namespace App\Service;

use App\Dto\Request\CreateBlogPostRequestDto;
use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;

class BlogPostService
{

    public function __construct(private BlogPostRepository $blogPostRepository)
    {
    }

    /**
     * @return BlogPost[]
     */
    public function getAllBlogPosts(): array
    {
        return $this->blogPostRepository->findAll();
    }


    /**
     * 
     * @return BlogPost
     */
    public function addBlogPost(CreateBlogPostRequestDto $createBlogPostRequestDto): BlogPost
    {

        $blogPost = new BlogPost();
        $blogPost->setTitle($createBlogPostRequestDto->getTitle());
        $blogPost->setContent($createBlogPostRequestDto->getContent());

        $this->blogPostRepository->save($blogPost, true);

        return $blogPost;
    }
}
