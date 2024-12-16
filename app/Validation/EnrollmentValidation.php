<?php

namespace App\Validation;

class EnrollmentValidation
{
    
   public function getRules(): array {

        return [                      

            'student_id' => [

                'rules' => "is_natural_no_zero|is_not_unique[students.id]",                
            ],

            'class_id' => [

                'rules' => "is_natural_no_zero|is_not_unique[classes.id]",                
            ],                        
        ];    
   }
}
