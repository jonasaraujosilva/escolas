<?php

use App\Controllers\Api\ApiParentsController;
use App\Controllers\AttendancesController;
use App\Controllers\ClassesController;
use App\Controllers\EnrollmentsController;
use App\Controllers\HomeController;
use App\Controllers\ParentsController;
use App\Controllers\SchedulesController;
use App\Controllers\StudentsController;
use App\Controllers\SubjectsController;
use App\Controllers\TeachersController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home']);



// Responsáveis
$routes->group('parents', static function ($routes) {
    $routes->get('/', [ParentsController::class, 'index'], ['as' => 'parents']);
    $routes->get('new', [ParentsController::class, 'new'], ['as' => 'parents.new']);
    $routes->post('create', [ParentsController::class, 'create'], ['as' => 'parents.create']);
    $routes->get('show/(:segment)', [ParentsController::class, 'show/$1'], ['as' => 'parents.show']);
    $routes->get('edit/(:segment)', [ParentsController::class, 'edit/$1'], ['as' => 'parents.edit']);
    $routes->put('update/(:segment)', [ParentsController::class, 'update/$1'], ['as' => 'parents.update']);
    $routes->delete('destroy/(:segment)', [ParentsController::class, 'destroy/$1'], ['as' => 'parents.destroy']);
});

// Alunos
$routes->group('students', static function ($routes) {
    $routes->get('/', [StudentsController::class, 'index'], ['as' => 'students']);
    $routes->get('new', [StudentsController::class, 'new'], ['as' => 'students.new']);
    $routes->post('create', [StudentsController::class, 'create'], ['as' => 'students.create']);
    $routes->get('show/(:segment)', [StudentsController::class, 'show/$1'], ['as' => 'students.show']);
    $routes->get('edit/(:segment)', [StudentsController::class, 'edit/$1'], ['as' => 'students.edit']);
    $routes->put('update/(:segment)', [StudentsController::class, 'update/$1'], ['as' => 'students.update']);
    $routes->delete('destroy/(:segment)', [StudentsController::class, 'destroy/$1'], ['as' => 'students.destroy']);
});

// Api
$routes->group('api', static function ($routes) {
    $routes->get('get-by-cpf', [ApiParentsController::class, 'getByCpf'], ['as' => 'api.fetch.parent.by.cpf']);
 
});

// Professores
$routes->group('teachers', static function ($routes) {
    $routes->get('/', [TeachersController::class, 'index'], ['as' => 'teachers']);
    $routes->get('new', [TeachersController::class, 'new'], ['as' => 'teachers.new']);
    $routes->post('create', [TeachersController::class, 'create'], ['as' => 'teachers.create']);
    $routes->get('show/(:segment)', [TeachersController::class, 'show/$1'], ['as' => 'teachers.show']);
    $routes->get('edit/(:segment)', [TeachersController::class, 'edit/$1'], ['as' => 'teachers.edit']);
    $routes->put('update/(:segment)', [TeachersController::class, 'update/$1'], ['as' => 'teachers.update']);
    $routes->delete('destroy/(:segment)', [TeachersController::class, 'destroy/$1'], ['as' => 'teachers.destroy']);
});

// Turmas
$routes->group('classes', static function ($routes) {
    $routes->get('/', [ClassesController::class, 'index'], ['as' => 'classes']);
    $routes->get('new', [ClassesController::class, 'new'], ['as' => 'classes.new']);
    $routes->post('create', [ClassesController::class, 'create'], ['as' => 'classes.create']);
    $routes->get('show/(:segment)', [ClassesController::class, 'show/$1'], ['as' => 'classes.show']);
    $routes->get('edit/(:segment)', [ClassesController::class, 'edit/$1'], ['as' => 'classes.edit']);
    $routes->put('update/(:segment)', [ClassesController::class, 'update/$1'], ['as' => 'classes.update']);
    $routes->delete('destroy/(:segment)', [ClassesController::class, 'destroy/$1'], ['as' => 'classes.destroy']);
});

// Disciplinas
$routes->group('subjects', static function ($routes) {
    $routes->get('/', [SubjectsController::class, 'index'], ['as' => 'subjects']);
    $routes->get('new', [SubjectsController::class, 'new'], ['as' => 'subjects.new']);
    $routes->post('create', [SubjectsController::class, 'create'], ['as' => 'subjects.create']);
    $routes->get('show/(:segment)', [SubjectsController::class, 'show/$1'], ['as' => 'subjects.show']);
    $routes->get('edit/(:segment)', [SubjectsController::class, 'edit/$1'], ['as' => 'subjects.edit']);
    $routes->put('update/(:segment)', [SubjectsController::class, 'update/$1'], ['as' => 'subjects.update']);
    $routes->delete('destroy/(:segment)', [SubjectsController::class, 'destroy/$1'], ['as' => 'subjects.destroy']);
});

// Horários das turmas
$routes->group('schedules', static function ($routes) {  
    $routes->get('get/(:segment)', [SchedulesController::class, 'index/$1'], ['as' => 'schedules']);
    $routes->put('store', [SchedulesController::class, 'store'], ['as' => 'schedules.store']);
});

// Matrículas
$routes->group('enrollments', static function ($routes) {  
    $routes->get('/', [EnrollmentsController::class, 'index'], ['as' => 'enrollments']);
    $routes->get('new', [EnrollmentsController::class, 'new'], ['as' => 'enrollments.new']);
    $routes->post('create', [EnrollmentsController::class, 'create'], ['as' => 'enrollments.create']);
    $routes->get('show/(:segment)', [EnrollmentsController::class, 'show/$1'], ['as' => 'enrollments.show']);
    $routes->get('renew/(:segment)', [EnrollmentsController::class, 'renew/$1'], ['as' => 'enrollments.renew']);
});

// Frequências
$routes->group('attendances', static function ($routes) {  
    $routes->get('get/(:segment)', [AttendancesController::class, 'index/$1'], ['as' => 'attendances']);
    $routes->get('print/(:segment)', [AttendancesController::class, 'print/$1'], ['as' => 'attendances.print']);
    $routes->put('store', [AttendancesController::class, 'store'], ['as' => 'attendances.store']);
});
