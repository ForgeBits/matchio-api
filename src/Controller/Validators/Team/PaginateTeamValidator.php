<?php

namespace App\Controller\Validators\Team;

use App\Controller\Validators\Validator;

class PaginateTeamValidator extends Validator
{
    protected function rules(): array
    {
        return [
            'name' => 'nullable',
            'city' => 'nullable',
        ];
    }

    protected function parameters(): array
    {
        return $this->request->getCurrentRequest()->query->all();
    }
}