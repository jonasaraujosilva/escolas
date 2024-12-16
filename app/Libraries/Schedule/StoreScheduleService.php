<?php

declare(strict_types=1);

namespace App\Libraries\Schedule;

use App\Models\ScheduleModel;
use InvalidArgumentException;
use PhpParser\Node\Stmt\TryCatch;

class StoreScheduleService {
    
  private ScheduleModel $scheduleModel;
  
  public function __construct()
  {
    $this->scheduleModel = model(ScheduleModel::class);
  }

  public function synchronize(array $request): bool {

    try {

        $request = esc($request);

        $classId = $request['schedule_details'][0]['class_id'] ?? null;

        if($classId === null){

            throw new InvalidArgumentException('Não veio no request o id da turma', 1);
        }


        // abrimos uma transaction
        $this->scheduleModel->db->transException(true)->transStart();

        // removemos os antigos
        $this->scheduleModel->where('class_id', $classId)->delete();

        // inserimos em batch
        $this->scheduleModel->insertBatch($request['schedule_details']);

        // fechamos a transaction
        $this->scheduleModel->db->transComplete();

        // retornamos true ou false
        return $this->scheduleModel->db->transStatus();

        
    } catch (\Throwable $th) {

        log_message('error', "Erro ao amarzenar os horários da turma: {$th->getMessage()}");

        return false;
    }

  }


}