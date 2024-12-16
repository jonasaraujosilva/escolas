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
                <a href="<?php echo route_to('subjects'); ?>" class="btn bg-gradient-dark mb-0"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Voltar</a>
            </div>
            <div class="card-body">

                <?php echo form_open(
                    action: route_to('subjects.update', $subject->code),
                    attributes: ['class' => 'form-floating'],
                    hidden: ['_method' => 'PUT']
                ); ?>

                <?php echo $this->include('Subjects/_form'); ?>



                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>



<?= $this->endSection() ?>