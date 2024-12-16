<?php

namespace App\Validation;

class ClassValidation
{
    
   public function getRules(?int $id = null): array {

        return [
            'id' => [

                'rules' => 'permit_empty|is_natural_no_zero'
            ],            

            'name' => [

                'rules' => "required|max_length[128]|is_unique[classes.name,id,{$id}]",
                'errors' => [
                    'required' => 'Informe o nome',                    
                ],
            ],

            'description' => [

                'rules' => "required|max_length[2000]",
                'errors' => [
                    'required' => 'Informe a descrição',                    
                ],
            ],
            
        ];    
   }
}
