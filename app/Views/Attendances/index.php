<?php echo $this->extend('Layouts/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>

<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #0d6efd;
    }
</style>


<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>

<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-0"><?php echo $title; ?></h6>
                <a href="<?php echo route_to('classes.show', $class->code); ?>" class="btn mb-3"><i class="fas fa-arrow-left" aria-hidden="true"></i></a>
            </div>
            <div class="card-body p-3">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Gerar Frequência</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Imprimir frequência</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">


                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                        <?php if ($studentsOptions === null) : ?>

                            <div class="alert alert-info">Turma sem estudantes para gerar frequência</div>

                        <?php else : ?>

                            <div class="row mt-4 pt-3 mb-3">

                                <div class="col-md-6">

                                    <div class="form-floating mb-3">
                                        <input type="date" required class="form-control" autocomplete="off" id="date" name="date">
                                        <label for="name">Data da frequência</label>
                                        <span class="small">As frequências que foram definidas anteriormente para a data escolhida serão removidas.</span>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <button class="btn bg-gradient-dark mb-0 btn-lg" disabled id="generateAttendances" style="height: 58px;">Gerar frequência</button>
                                </div>

                            </div>


                            <div class="table-responsive">

                                <?php echo $studentsOptions; ?>

                            </div>



                        <?php endif; ?>


                    </div>


                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">



                        <form class="form-inline" action="<?php echo route_to('attendances.print', $class->code); ?>" target="_blank" method="get">


                            <div class="row pt-3">

                                <div class="col-md-6">

                                    <div class="form-floating mb-3">
                                        <input type="month" required class="form-control" id="month" name="month">
                                        <label for="name">Data da frequência</label>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-dark btn-lg" id="btnPrintAttendance" style="height: 58px;">Imprimir</button>
                                </div>

                            </div>

                        </form>



                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>

<?php if ($studentsOptions !== null) : ?>
    <script>
        // script primeira aba
        window.onload = function() {

            const dateToBeGenerated = document.getElementById('date');

            if (dateToBeGenerated) {

                dateToBeGenerated.addEventListener('change', () => {

                    const generateAttendances = document.getElementById('generateAttendances');

                    // quando ocorrer uma mudança na data e tiver valor, habilitamos o botão,
                    // caso contrário desabilita
                    generateAttendances.disabled = !dateToBeGenerated.value;

                    // getUTCDay() é chamado para obter o dia da semana (de 0 a 6), 
                    const day = new Date(dateToBeGenerated.value).getUTCDay();

                    // onde 0 representa domingo e 6 representa sábado.
                    if ([0, 6].includes(day)) {

                        // limpamos a data do final se semana
                        dateToBeGenerated.value = '';

                        // desabilita o botão
                        generateAttendances.disabled = true;

                        Toastify({
                            text: "Escolhas apenas dias úteis",
                            close: true,
                            gravity: "bottom",
                            position: "left",
                            backgroundColor: "#fd7e14",
                        }).showToast();

                        return;
                    }
                });

            }

            // array de estudantes associados à turma
            const students = <?php echo json_encode($class->students); ?>;

            // receberá os estudantes e o status de presentça
            const statusArray = [];

            // Inicializa o statusArray com todos os alunos do array $class->students com status false
            students.forEach(student => {
                statusArray.push({
                    id: student.id,
                    status: false,
                });
            });

            const studentOptions = document.querySelectorAll('.student-option');

            studentOptions.forEach(option => {
                option.addEventListener('click', () => {

                    const id = option.getAttribute('data-id'); // definido na classe de serviço
                    const status = option.checked;

                    // Quando um checkbox é clicado, o código obtém o elemento irmão seguinte do checkbox (que é o rótulo <label>) 
                    // e atualiza o seu texto para 'Compareceu' ou 'Faltou' com base no estado do checkbox.
                    const label = option.nextElementSibling;
                    const text = status ? 'Compareceu' : 'Faltou';
                    label.textContent = text;



                    // Atualiza o statusArray com o status do checkbox clicado
                    const studentIndex = statusArray.findIndex(student => student.id === id);
                    if (studentIndex !== -1) {
                        statusArray[studentIndex].status = status;
                    } else {
                        statusArray.push({
                            id,
                            status
                        });
                    }
                });
            });



            const btnGenerateAttendances = document.getElementById('generateAttendances');

            if (btnGenerateAttendances) {

                btnGenerateAttendances.addEventListener('click', () => {

                    btnGenerateAttendances.disabled = true;
                    btnGenerateAttendances.textContent = 'Por favor aguarde...';

                    // o que será enviado no request
                    const bodyRequest = {
                        class_id: '<?php echo $class->id; ?>',
                        attendances: statusArray,
                        date: dateToBeGenerated.value,
                    };

                    // CSRF CODE PARA ENVIAR NO REQUEST
                    let csrfTokenName = '<?php echo csrf_token(); ?>';
                    let csrfTokenValue = '<?php echo csrf_hash(); ?>';

                    // colocamos no body os dados de CSRF
                    bodyRequest[csrfTokenName] = csrfTokenValue;

                    // Enviar os dados com fetch API
                    fetch('<?php echo route_to('attendances.store'); ?>', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(bodyRequest)
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erro gerar frequência.');
                            }

                            return response.json();
                        })
                        .then(data => {

                            // redirecionamos para essa rota mesmo
                            window.location.href = '<?php echo route_to('attendances', $class->code); ?>';
                        })
                        .catch(error => {
                            console.error('Erro ao enviar requisição:', error);
                            Toastify({
                                text: "Erro ao enviar os horários",
                                duration: 10000,
                                close: true,
                                gravity: "bottom",
                                position: "right",
                                backgroundColor: "#dc3545",
                            }).showToast();
                        });

                });
            }
        };
    </script>
<?php endif; ?>



<?php echo $this->endSection(); ?>