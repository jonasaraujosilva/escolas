<?php

namespace App\Validation;

use App\Traits\CPFValidationTrait;

class ParentValidation
{

    use CPFValidationTrait;

   public function getRules(?int $id = null): array {

        return [
            'id' => [

                'rules' => 'permit_empty|is_natural_no_zero'
            ],

            'name' => [

                'rules' => "required|max_length[128]",
                'errors' => [
                    'required' => 'Informe o nome completo',
                    'max_length' => 'O nome não pode ter mais que 128 caractéres',
                ],
            ],

            'cpf' => [

                'rules' => "required|exact_length[14]|validaCPF|is_unique[parents.cpf,id,{$id}]",
                'errors' => [
                    'required' => 'Informe o CPF válido',
                    'exact_length' => 'O CPF precisa ter exatamente 14 caractéres',
                    'is_unique' => 'Esse CPF já existe',
                ],
            ],

            'email' => [

                'rules' => "required|max_length[128]valid_email|is_unique[parents.email,id,{$id}]",
                'errors' => [
                    'required' => 'Informe o E-mail',                    
                ],
            ],

            'phone' => [

                'rules' => "required|max_length[128]|is_unique[parents.phone,id,{$id}]",
                'errors' => [
                    'required' => 'Informe o Telefone',                    
                ],
            ],
        ];
   }
}
