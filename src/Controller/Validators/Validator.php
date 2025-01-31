<?php

namespace App\Controller\Validators;

use App\Exception\RequestValidationException;
use Symfony\Component\HttpFoundation\RequestStack;
use \Rakit\Validation\Validator as RakitValidator;
use Symfony\Component\HttpFoundation\Response;

abstract class Validator
{
    /**
     * @throws RequestValidationException
     */
    public function __construct(
        public readonly RequestStack $request
    ){
        $this->validate();
    }

    protected abstract function rules(): array;
    protected abstract function parameters(): array;

    /**
     * @throws RequestValidationException
     */
    protected function validate(): void
    {
        $validator = new RakitValidator();
        $validated = $validator->validate($this->parameters(), $this->rules());

        if ($validated->fails()) {
            throw new RequestValidationException($validated->errors()->toArray(), 'Data validation failed', Response::HTTP_BAD_REQUEST);
        }
    }
}