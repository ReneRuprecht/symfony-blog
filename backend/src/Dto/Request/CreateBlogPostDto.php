<?php

namespace App\Dto\Request;



class CreateBlogPostDto
{

    public function __construct(private string $title, private string $content)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function getContent(): string
    {
        return $this->content;
    }
}
