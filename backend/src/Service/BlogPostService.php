<?php

namespace App\Service;

use App\Dto\Request\CreateBlogPostRequestDto;
use App\Dto\Request\UpdateBlogPostRequestDto;
use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityNotFoundException;

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
     * @param CreateBlogPostRequestDto $createBlogPostRequestDto) 
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

    /**
     * @param UpdateBlogPostRequestDto $updateBlogPostRequestDto
     * @throws EntityNotFoundException
     * @return BlogPost
     */
    public function updateBlogPost(UpdateBlogPostRequestDto $updateBlogPostRequestDto): BlogPost
    {

        $blogPost = $this->blogPostRepository->find($updateBlogPostRequestDto->getId());

        if (!$blogPost)
            throw new EntityNotFoundException("Blogpost with id " . $updateBlogPostRequestDto->getId() . " does not exist");

        if (!$updateBlogPostRequestDto->getTitle() && !$updateBlogPostRequestDto->getContent())
            return $blogPost;

        if ($updateBlogPostRequestDto->getTitle())
            $blogPost->setTitle($updateBlogPostRequestDto->getTitle());

        if ($updateBlogPostRequestDto->getContent())
            $blogPost->setContent($updateBlogPostRequestDto->getContent());

        $this->blogPostRepository->save($blogPost, true);

        return $blogPost;
    }
}
