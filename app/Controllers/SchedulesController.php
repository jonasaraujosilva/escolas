<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Schedule\StoreScheduleService;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;
use CodeIgniter\HTTP\Response;

class SchedulesController extends BaseController
{

    private const VIEWS_DIRECTORY = 'Schedules/';

    private ClassModel $classModel;

    public function __construct()
    {
        $this->classModel = model(ClassModel::class);
    }

    public function index(string $classCode)
    {
        $class = $this->classModel->getByCode(code: $classCode, withSchedules: true);

        $this->dataToView['title']      = "Gerenciar os horários da turma: {$class->name}";
        $this->dataToView['class']      = $class;
        $this->dataToView['subjects']   = model(SubjectModel::class)->orderBy('name', 'ASC')->findAll();
        $this->dataToView['teachers']   = model(TeacherModel::class)->orderBy('name', 'ASC')->findAll();

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function store(): Response
    {       

        $request = $this->request->getJSON(assoc: true);

        $storeService = new StoreScheduleService;

        $success = $storeService->synchronize(request: $request);

        if (!$success) {

            return $this->response->setStatusCode(500, 'Erro ao salvar horários');
        }

        session()->setFlashdata('success', 'Horário criado com sucesso!');

        return $this->response->setStatusCode(200)->setJSON(['success' => true]);
    }
}
