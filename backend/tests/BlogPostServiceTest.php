<?php

namespace App\Tests;

use App\Dto\Request\CreateBlogPostRequestDto;
use App\Dto\Request\UpdateBlogPostRequestDto;
use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use App\Service\BlogPostService;
use Doctrine\ORM\EntityNotFoundException;
use PharIo\Manifest\InvalidEmailException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BlogPostServiceTest extends KernelTestCase
{
    public function testGetAllBlogPostsShouldGetEmptyResult(): void
    {
        $blogPostRepository = $this->createMock(BlogPostRepository::class);

        $BlogPostService = new BlogPostService($blogPostRepository);

        $blogPostRepository->expects($this->any())
            ->method('findAll')
            ->willReturn([]);

        $this->assertEquals([], $BlogPostService->getAllBlogPosts());
    }
    public function testAddBlogPostShouldAddBlogPost(): void
    {

        $expectedTitle = "testTitle";
        $expectedcontent = "testContent";

        $createBlogPostDto = $this->createMock(CreateBlogPostRequestDto::class);
        $createBlogPostDto->expects($this->any())
            ->method('getTitle')
            ->willReturn($expectedTitle);
        $createBlogPostDto->expects($this->any())
            ->method('getContent')
            ->willReturn($expectedcontent);

        $this->assertEquals($expectedTitle, $createBlogPostDto->getTitle());
        $this->assertEquals($expectedcontent, $createBlogPostDto->getContent());

        $blogPostRepository = $this->createMock(BlogPostRepository::class);

        $blogPostRepository->expects($this->once())->method('save');
        $BlogPostService = new BlogPostService($blogPostRepository);

        $createdBlogPost = $BlogPostService->addBlogPost($createBlogPostDto);

        $this->assertEquals($expectedTitle, $createdBlogPost->getTitle());
        $this->assertEquals($expectedcontent, $createdBlogPost->getContent());
    }

    public function testUpdateBlogPostShouldUpdateBlogPost(): void
    {
        $expectedTitle = "updatedTitle";
        $expectedcontent = "updatedContent";


        $updateBlogPostDto = $this->createMock(UpdateBlogPostRequestDto::class);
        $updateBlogPostDto->expects($this->once())
            ->method('getId')
            ->willReturn(1);
        $updateBlogPostDto->expects($this->any())
            ->method('getTitle')
            ->willReturn($expectedTitle);
        $updateBlogPostDto->expects($this->any())
            ->method('getContent')
            ->willReturn($expectedcontent);

        $blogPost = new BlogPost();
        $blogPost->setTitle("testTitle");
        $blogPost->setContent("testContent");

        $blogPostRepository = $this->createMock(BlogPostRepository::class);

        $BlogPostService = new BlogPostService($blogPostRepository);

        $blogPostRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($blogPost);

        $createdBlogPost = $BlogPostService->updateBlogPost($updateBlogPostDto);

        $this->assertEquals($expectedTitle, $createdBlogPost->getTitle());
        $this->assertEquals($expectedcontent, $createdBlogPost->getContent());
    }

    public function testUpdateBlogPostShouldThrowEntityNotFoundException(): void
    {

        $updateBlogPostDto = $this->createMock(UpdateBlogPostRequestDto::class);
        $updateBlogPostDto->expects($this->any())
            ->method('getId')
            ->willReturn(1);

        $blogPostRepository = $this->createMock(BlogPostRepository::class);

        $BlogPostService = new BlogPostService($blogPostRepository);

        $blogPostRepository->expects($this->once())
            ->method('find')
            ->with(1);

        $this->expectException(EntityNotFoundException::class);
        $BlogPostService->updateBlogPost($updateBlogPostDto);
    }

    public function testUpdateBlogPostShouldNotUpdateBlogPostWithEmptyTitleAndContentInsideDto(): void
    {
        $expectedTitle = "testTitle";
        $expectedcontent = "testContent";


        $updateBlogPostDto = $this->createMock(UpdateBlogPostRequestDto::class);
        $updateBlogPostDto->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $blogPost = new BlogPost();
        $blogPost->setTitle("testTitle");
        $blogPost->setContent("testContent");

        $blogPostRepository = $this->createMock(BlogPostRepository::class);

        $BlogPostService = new BlogPostService($blogPostRepository);

        $blogPostRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($blogPost);

        $createdBlogPost = $BlogPostService->updateBlogPost($updateBlogPostDto);

        $this->assertEquals($expectedTitle, $createdBlogPost->getTitle());
        $this->assertEquals($expectedcontent, $createdBlogPost->getContent());
    }


}
