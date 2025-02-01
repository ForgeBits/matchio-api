<?php

namespace App\Controller\Validators\Team;

use App\Controller\Validators\Validator;

class CreateTeamValidator extends Validator
{
    protected function rules(): array
    {
        return [
            'name' => 'required',
            'founded' => 'required',
            'stadium' => 'required',
            'city' => 'required',
            'country' => 'required|in:'.$this->countries()
        ];
    }

    private function countries(): string
    {
        return 'England,Brazil,Germany,Spain,Italy,France,Netherlands,Portugal,Argentina,Belgium,Colombia,Uruguay,
            Chile,Sweden,Switzerland,Denmark,Japan,United States,Mexico,Poland,Austria,Croatia,Czech Republic,Scotland,
            Turkey,Ukraine,Russia,Paraguay,Peru,Senegal,Nigeria,Cameroon,Egypt,Morocco,Tunisia,Australia,Iran,South Korea,
            Saudi Arabia';
    }

    protected function parameters(): array
    {
        return $this->request->getCurrentRequest()->toArray();
    }
}