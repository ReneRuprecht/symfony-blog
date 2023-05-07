<?php

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateBlogPostRequestDto extends AbstractBaseRequestDto
{

    #[Type('string')]
    #[NotBlank()]
    protected string $title;

    #[Type('string')]
    #[NotBlank([])]
    protected string $content;

    public function gettitle(): string
    {
        return $this->title;
    }
    public function getContent(): string
    {
        return $this->content;
    }
}