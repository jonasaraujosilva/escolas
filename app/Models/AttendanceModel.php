<?php

namespace App\Models;

use App\Entities\Attendance;
use App\Models\Basic\AppModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

class AttendanceModel extends AppModel
{
    protected $table            = 'attendances';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Attendance::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [        
        'class_id',
        'student_id',        
        'status',        
        'date',        
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData'];
    protected $beforeUpdate   = ['escapeData'];

    
    public function getAllByStudentId(int $studentId, ?string $oldDate = null): array {

        $date = $oldDate ? Time::parse($oldDate) : Time::now();
        $month = $date->format('m'); // MM
        $year = $date->format('Y'); // YYYY

        $where = [
            'MONTH(date)'   => $month,
            'YEAR(date)'    => $year,
            'student_id'    => $studentId,
        ];

        $this->select([
            '*', // Todas as colunas

            // Preciso dar um apelido para os cabos a baixo para fins de compração ao longo do código
            'DAY(date) AS day',
            'MONTH(date) AS month',
            'YEAR(date) AS year',
        ]);

        $this->where($where);

        return $this->findAll();
    }
}
