<?= $this->extend('Layouts/main') ?>

<?= $this->section('title') ?>
<?php echo $title; ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>



<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?php echo $title; ?></h6>
                <a href="<?php echo route_to('enrollments'); ?>" class="btn bg-gradient-dark mb-0"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Voltar</a>


                <a href="<?php echo route_to('students.new') . "?parent_code={$parent->code}"; ?>" class="btn mb-0 bg-gradient-info float-end"><i class="fas fa-plux"></i>&nbsp;Adicionar estudante</a>
            </div>
            <div class="card-body">

                <?php echo form_open(
                    action: route_to('enrollments.create'),
                    attributes: ['class' => 'form-floating']
                ); ?>

                <div class="row">
                    <div class="col-md-12 mb-4">

                        <div class="form-floating mb-3">
                            <input type="text" disabled class="form-control" value="<?php echo $parent->name . ' CPF ' . $parent->cpf; ?>">
                            <label for="name">Responsável</label>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-4">

                        <div class="form-floating mb-3">
                            <select name="student_id" id="student_id" class="form-select" required>

                                <?php if (empty($parent->students)): ?>

                                    <option value="" selected>--- Responsável sem estudantes ---</option>

                                <?php else: ?>

                                    <?php foreach ($parent->students as $student): ?>

                                        <option value="<?php echo $student->id; ?>"><?php echo $student->name; ?></option>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </select>
                            <label for="student_id">Escolha um aluno</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">

                        <div class="form-floating mb-3">
                            <select name="class_id" id="class_id" class="form-select" required>

                                <?php if (empty($classes)): ?>

                                    <option value="" selected>--- Não há turmas disponíveis ---</option>

                                <?php else: ?>

                                    <?php foreach ($classes as $class): ?>

                                        <option value="<?php echo $class->id; ?>" <?php echo(int) ($enrollment->class_id === (int) $class->id) ? 'selected' : ''; ?>><?php echo $class->name; ?></option>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </select>
                            <label for="class_id">Escolha uma turma</label>
                        </div>
                    </div>


                </div>



                <div class="row mt-3">

                    <div class="col-md-12">

                        <button type="submit" class="btn bg-gradient-dark"><?php echo $enrollment->id ? 'Renovar matrícula' : 'Criar matrícula'; ?></button>

                    </div>

                </div>

                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>



<?= $this->endSection() ?>