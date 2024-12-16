<?php

namespace App\Validation;


class AddressValidation
{

    public function getRules(): array
    {

        return [

            'postalcode' => [

                'rules'     => "required",
                'errors'    => [
                'required'  => 'Informe o CEP',
                ],
            ],

            'street' => [

                'rules'     => "required",
                'errors'    => [
                'required'  => 'Informe a Rua',
                ],
            ],

            'district' => [

                'rules'     => "required",
                'errors'    => [
                'required'  => 'Informe o Bairro',
                ],
            ],

            'number' => [

                'rules'     => "permit_empty",
            ],

            'city' => [

                'rules'     => "required",
                'errors'    => [
                'required'  => 'Informe a Cidade',
                ],
            ],

            'state' => [

                'rules'     => "required",
                'errors'    => [
                'required'  => 'Informe o Estado',
                ],
            ],

        ];
    }
}
