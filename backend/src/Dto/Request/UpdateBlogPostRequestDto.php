<?php

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class UpdateBlogPostRequestDto extends AbstractBaseRequestDto
{

    #[Type('int')]
    #[NotBlank()]
    protected int $id;

    #[Type('string')]
    protected ?string $title = null;

    #[Type('string')]
    protected ?string $content = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ?string
     */
    public function gettitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
}
