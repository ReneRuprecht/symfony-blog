<?php

namespace App\Dto\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractBaseRequestDto
{

    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
    }

    public function validate(): bool
    {
        $errors = $this->validator->validate($this);

        if (count($errors) > 0) return false;

        return true;
    }

    protected function populate(): void
    {
        $requestFields = Request::createFromGlobals()->toArray();

        foreach ($requestFields as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
