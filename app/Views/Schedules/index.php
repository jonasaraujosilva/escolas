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
        <a href="<?php echo route_to('classes.show', $class->code); ?>" class="btn bg-gradient-dark mb-0"><i class="fas fa-eye"></i>&nbsp;&nbsp;Detalhes</a>
      </div>
      <div class="card-body pb-2">

        <div class="row">

          <div class="col-md-12 mb-3">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" readonly value="<?php echo $class->name; ?>">
              <label>Turmas</label>
            </div>
          </div>

          <div class="col-md-12">

            <label for="schedule">Horários da turma</label>

            <div id="scheduleContainer">

              <!-- Adicionados pelo script -->


              <?php foreach ($class->schedules as $schedule) : ?>

                <div class="mb-3">

                  <div class="row">
                    <div class="col-md">
                      <select class="form-select" name="day_of_week">
                        <option value="1" <?php echo ($schedule->day_of_week === 1 ? 'selected' : ''); ?>>Segunda-feira</option>
                        <option value="2" <?php echo ($schedule->day_of_week === 2 ? 'selected' : ''); ?>>Terça-feira</option>
                        <option value="3" <?php echo ($schedule->day_of_week === 3 ? 'selected' : ''); ?>>Quarta-feira</option>
                        <option value="4" <?php echo ($schedule->day_of_week === 4 ? 'selected' : ''); ?>>Quinta-feira</option>
                        <option value="5" <?php echo ($schedule->day_of_week === 5 ? 'selected' : ''); ?>>Sexta-feira</option>
                        <option value="6" <?php echo ($schedule->day_of_week === 6 ? 'selected' : ''); ?>>Sábado</option>
                        <option value="7" <?php echo ($schedule->day_of_week === 7 ? 'selected' : ''); ?>>Domingo</option>
                      </select>
                    </div>
                    <div class="col-md">
                      <input type="time" value="<?php echo $schedule->start_at; ?>" class="form-control" name="start_at">
                    </div>
                    <div class="col-md">
                      <input type="time" value="<?php echo $schedule->end_at; ?>" class="form-control" name="end_at">
                    </div>
                    <div class="col-md">
                      <select class="form-select" name="subject_id">
                        <?php foreach ($subjects as $subject) : ?>

                          <option value="<?php echo $subject->id; ?>" <?php echo ((int) $schedule->subject_id === (int) $subject->id ? 'selected' : ''); ?>><?php echo $subject->name; ?></option>

                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md">
                      <select class="form-select" name="teacher_id">
                        <?php foreach ($teachers as $teacher) : ?>

                          <option value="<?php echo $teacher->id; ?>" <?php echo ((int) $schedule->teacher_id === (int) $teacher->id ? 'selected' : ''); ?>><?php echo $teacher->name; ?></option>

                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <button class="btn-remove btn badge bg-danger"><i class="fas fa-trash"></i></button>

                </div>

              <?php endforeach; ?>


            </div>

          </div>

          <div class="col-md-2">

            <button type="buttom" class="btn btn-sm mt-3 badge bg-dark" id="addSchedule"><i class="fas fa-plus"></i></button>

          </div>

        </div>



        <hr>

        <div class="row">

          <div class="col-md-4">

            <button type="buttom" class="btn bg-gradient-dark" id="generateSchedule">Gerar horário</button>

          </div>

        </div>

      </div>
    </div>
  </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script>
  // quando for renderiza a view e a class já tiver horários,
  // colocamos um ouvinte no clique do botão 'btn-remove'
  document.querySelectorAll('.btn-remove').forEach(button => {
    button.addEventListener('click', function() {
      this.parentNode.remove();
    });
  });
</script>

<script>
  // Array de disciplinas enviado pelo controller
  const subjects = <?php echo json_encode($subjects); ?>;

  // Array de professores enviado pelo controller
  const teachers = <?php echo json_encode($teachers); ?>;

  // Função para adicionar campos para adicionar horários de aula
  document.getElementById('addSchedule').addEventListener('click', function() {
    const container = document.getElementById('scheduleContainer');
    let scheduleField = document.createElement('div');
    scheduleField.className = 'mb-3';
    scheduleField.innerHTML = `
                <div class="row">
                    <div class="col-md">
                        <select class="form-select" name="day_of_week">
                            <option value="1">Segunda-feira</option>
                            <option value="2">Terça-feira</option>
                            <option value="3">Quarta-feira</option>
                            <option value="4">Quinta-feira</option>
                            <option value="5">Sexta-feira</option>
                            <option value="5">Sábado</option>
                            <option value="5">Domingo</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <input type="time" class="form-control" name="start_at">
                    </div>
                    <div class="col-md">
                        <input type="time" class="form-control" name="end_at">
                    </div>
                    <div class="col-md">
                        <select class="form-select" name="subject_id">
                            <!-- Opções de disciplinas serão preenchidas dinamicamente -->
                        </select>
                    </div>
                    <div class="col-md">
                        <select class="form-select" name="teacher_id">
                            <!-- Opções de professores serão preenchidos dinamicamente -->
                        </select>
                    </div>
                </div>
            `;

    // Adiciona opções de disciplinas ao menu suspenso
    const subjectSelect = scheduleField.querySelector('select[name="subject_id"]');

    if (subjects.length === 0) {
      // Desabilita o dropdown
      subjectSelect.disabled = true;

      // Cria e adiciona a opção "Não há disciplinas"
      let option = document.createElement('option');
      option.text = "Não há disciplinas";
      option.value = "";
      subjectSelect.appendChild(option);
    } else {
      // Habilita o dropdown
      subjectSelect.disabled = false;

      // Adiciona as disciplinas ao dropdown
      subjects.forEach(function(subject) {
        let option = document.createElement('option');
        option.text = subject.name;
        option.value = subject.id;
        subjectSelect.appendChild(option);
      });
    }

    // Adiciona opções de professores ao menu suspenso
    const teacherSelect = scheduleField.querySelector('select[name="teacher_id"]');

    if (teachers.length === 0) {
      // Desabilita o dropdown
      teacherSelect.disabled = true;

      // Cria e adiciona a opção "Não há professores"
      let option = document.createElement('option');
      option.text = "Não há professores";
      option.value = "";
      teacherSelect.appendChild(option);
    } else {
      // Habilita o dropdown
      teacherSelect.disabled = false;
      teachers.forEach(function(teacher) {
        let option = document.createElement('option');
        option.text = teacher.name;
        option.value = teacher.id;
        teacherSelect.appendChild(option);
      });

    }



    // Adiciona o campo criado ao container
    container.appendChild(scheduleField);

    // Adiciona um botão de exclusão em cada linha de horário
    const deleteButton = document.createElement('button');
    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
    deleteButton.className = 'btn badge bg-danger btn-sm';
    deleteButton.addEventListener('click', function() {
      scheduleField.remove(); // Remove a linha de horário ao clicar no botão de exclusão
    });
    scheduleField.appendChild(deleteButton);

  });


  // botão de gerar horário
  const btnGenerateSchedule = document.getElementById('generateSchedule');

  // Função para gerar o horário
  btnGenerateSchedule.addEventListener('click', function() {
    const schedules = document.querySelectorAll('#scheduleContainer .row');
    const scheduleDetails = [];
    schedules.forEach(function(schedule) {
      const dayOfWeek = schedule.querySelector('select[name="day_of_week"]').value;
      const startAt = schedule.querySelector('input[name="start_at"]').value;
      const endAt = schedule.querySelector('input[name="end_at"]').value;
      const subjectId = schedule.querySelector('select[name="subject_id"]').value;
      const teacherId = schedule.querySelector('select[name="teacher_id"]').value;

      // todos os campos estão preenchidos?
      if (!dayOfWeek || !startAt || !endAt || !subjectId || !teacherId) {

        Toastify({
          text: 'Por favor, preencha todos os campos de horário e disciplina',
          close: true,
          duration: 10000, // um pouco maior a duração
          gravity: "top",
          position: "left",
          backgroundColor: "#dc3545",
        }).showToast();

        return;
      }

      scheduleDetails.push({
        day_of_week: parseInt(dayOfWeek),
        start_at: startAt,
        end_at: endAt,
        class_id: parseInt('<?php echo $class->id; ?>'),
        subject_id: parseInt(subjectId),
        teacher_id: parseInt(teacherId)
      });
    });


    // se estiver vazio, não fazemos nada
    if (scheduleDetails.length === 0) {

      return;
    }

    // desabilita o botão de gerar horário
    btnGenerateSchedule.disabled = true;
    btnGenerateSchedule.textContent = 'Por favor aguarde...';

    // o que será enviado no request
    const bodyRequest = {
      schedule_details: scheduleDetails,
    };

    // CSRF CODE PARA ENVIAR NO REQUEST
    let csrfTokenName = '<?php echo csrf_token(); ?>';
    let csrfTokenValue = '<?php echo csrf_hash(); ?>';

    // colocamos no body os dados de CSRF
    bodyRequest[csrfTokenName] = csrfTokenValue;

    // Enviar os dados com fetch API
    fetch('<?php echo route_to('schedules.store'); ?>', {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(bodyRequest)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro ao enviar os horários.');
        }

        return response.json();
      })
      .then(data => {

        // redirecionamos para essa rota mesmo
        window.location.href = '<?php echo route_to('schedules', $class->code); ?>';
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
</script>


<?= $this->endSection() ?>