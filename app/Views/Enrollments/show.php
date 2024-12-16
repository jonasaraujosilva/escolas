<?= $this->extend('Layouts/main') ?>

<?= $this->section('title') ?>
<?php echo $title; ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>



<?= $this->endSection() ?>


<?= $this->section('content') ?>


<div class="col-12">
    <div class="card h-100">
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <h6 class="mb-0"><?php echo $title; ?></h6>
                </div>
                <div class="col-md-4 text-end">
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('enrollments'); ?>">
                        <i class="fas fa-arrow-left text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"></i>
                    </a>
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('enrollments.renew', $enrollment->code); ?>">
                        <i class="fas fa-sync-alt text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Renovar"></i>
                    </a>                    
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <hr class="horizontal gray-light my-4">
            <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Código da matrícula:</strong> &nbsp; <?php echo $enrollment->code; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Matrícula realizada em:</strong> &nbsp; <?php echo $enrollment->createdAt(); ?></li>
       
                <li class="list-group-item border-0 ps-0 ms-0 text-sm"><strong class="text-dark">Estudante:</strong> &nbsp;
                    <a target="_blank" class="btn btn-link mb-0 ms-0 p-0" href="<?php echo route_to('students.show', $enrollment->student->code); ?>">
                        <i class="fa fa-eye text-secondary text-sm"> &nbsp;&nbsp; </i><?php echo $enrollment->student->name; ?> - CPF: <?php echo $enrollment->student->cpf; ?>
                    </a>
                </li>

                <li class="list-group-item border-0 ps-0 ms-0 text-sm"><strong class="text-dark">Turma:</strong> &nbsp;
                    <a target="_blank" class="btn btn-link mb-0 ms-0 p-0" href="<?php echo route_to('classes.show', $enrollment->class->code); ?>">
                        <i class="fa fa-eye text-secondary text-sm"> &nbsp;&nbsp; </i><?php echo $enrollment->class->name; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>



<?= $this->endSection() ?>