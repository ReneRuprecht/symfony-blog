<?php

namespace App\Dto\Request;


use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;


class DeleteBlogPostRequestDto extends AbstractBaseRequestDto
{
    #[Type('int')]
    #[NotBlank()]
    protected int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
