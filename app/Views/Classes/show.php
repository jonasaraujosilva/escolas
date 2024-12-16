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
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('classes.edit', $class->code); ?>">
                        <i class="fas fa-arrow-left text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"></i>
                    </a>
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('classes.edit', $class->code); ?>">
                        <i class="fas fa-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></i>
                    </a>

                    <?php echo form_open(
                        action: route_to('classes.destroy', $class->code),
                        attributes: ['class' => 'form-floating d-inline', 'onsubmit' => 'return confirm("Deseja realmente excluir a Turma?")'],
                        hidden: ['_method' => 'DELETE']
                    ); ?>

                    <button class="btn btn-sm" type="submit"><i class="fas fa-trash text-danger text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"></i></button>



                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <hr class="horizontal gray-light my-4">
            <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nome:</strong> &nbsp; <?php echo $class->name; ?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Descrição:</strong> &nbsp; <?php echo $class->description; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Criado:</strong> &nbsp; <?php echo $class->created_at->humanize(); ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Atualizado:</strong> &nbsp; <?php echo $class->updated_at->humanize(); ?></li>

            </ul>
        </div>
    </div>
</div>

<div class="col-12 mt-4">
    <div class="card h-100">
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <h6 class="mb-0">Horários da turma</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('schedules', $class->code); ?>">
                        <i class="fas fa-calendar text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Gerenciar horários"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-3">

            <div class="table-responsive">

                <?php echo $class->schedules(); ?>

            </div>

        </div>
    </div>
</div>


<div class="col-12 mt-4">
    <div class="card h-100">
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <h6 class="mb-0">Estudantes matriculados na turma no ano de <?php echo date('Y'); ?></h6>
                </div>
                <div class="col-md-4 text-end">
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('attendances', $class->code); ?>">
                        <i class="fas fa-check text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Gerenciar frequência"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-3">

            <div class="table-responsive">

                <?php echo $class->students(); ?>

            </div>

        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>



<?= $this->endSection() ?>