<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php';
?>
        
        <div id="app">
          <div>
            <!-- <pre> -->
            <?php
              if ( count( $nearestProjects ) > 0 ) {
                  echo '<h2>Подходят к завершению договорные сроки проектов: </h2>';
                  foreach( $nearestProjects as $prjcs ) {
                    // echo $prjcs['content'] . ' - ' . date( 'd.m.Y', strtotime($prjcs['end']) ) . '<br>';
                    echo '<p>' . $prjcs['content'] . ' - ' . date( 'd.m.Y', strtotime($prjcs['end']) ) . '</p>';
                  }
              }
            ?>
            <!-- </pre> -->
          </div>
      <input type="hidden" name="view" value="table">

      <div  v-show=" view == 'table' ">
        <h2>Таблица объектов</h2>


        <div class="table-wrapper" v-if="sched && sched.length > 0">
          <table border="1" class="schedule table">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td v-for=" tsk in sched " style="text-align: center;">
                {{ tsk.content }}
              </td>
            </tr>
            <tr v-for="group in groups">
              <td>
                <template v-for="user in group.users">
                  <a :href="'/user.php?id=' + user.id">{{ user.name  }}</a> <br>
                </template>
              </td>
              <td>
                <table class="inner-table">
                  <tr><td>Дог. сроки н/к/отч</td></tr>
                  <tr><td>Допуск</td></tr>
                  <tr><td>Проведение работ</td></tr>
                  <tr><td>Отчеты  к/отпр</td></tr>
                </table>
              </td>
              <td v-for=" tsk in sched ">
                <!-- <task-table :tasks=" tsk "></task-table> -->
                <template v-if="group.id == tsk.group">
                  <task-table :tasks=" tsk.tasks "></task-table>
                </template>
                <template v-else>
                  <task-table :tasks=" null "></task-table>
                </template>
              </td>
            </tr>
          </table>
        </div>
      </div>


      <button class="modal-default-button btn btn-success" @click="showModal = true">
        Добавить
      </button>

      <!-- <button id="show-modal" @click="showModal = true">Show Modal</button> -->
      <!-- use the modal component, pass in the prop -->
      <modal v-if="showModal" @close="showModal = false">
        <!-- <input type="text" class="datetime"> -->
        <h3 slot="header">{{ action_label }}</h3>

        <div slot="body">
          <div class="row">
            <div class="col-md-12">
              <h3>О проекте</h3>
            </div>
          </div>

          <div class="row dates-row">
            <div class="col-md-4">
              Название проекта
            </div>
            <div class="col-md-8">
              <input type="text" v-model="project_modal_data.title" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h3>Договорные сроки</h3>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Проведение работ
            </div>
            <div class="col-md-8">
              <date-picker v-model="project_modal_data.dates.contract.work" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Сдача отчета
            </div>
            <div class="col-md-8">
              <date-picker v-model="project_modal_data.dates.contract.report" lang="ru" format="YYYY-MM-DD" confirm></date-picker>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h3>Реальные сроки</h3>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Допуск
            </div>
            <div class="col-md-8">
              <date-picker v-model="project_modal_data.dates.real.adm" range lang="ru" format="YYYY-MM-DD" valueType="'date'" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Проведение работ
            </div>
            <div class="col-md-8">
              <date-picker v-model="project_modal_data.dates.real.work" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Сдача технических отчетов
            </div>
            <div class="col-md-4">
              <date-picker v-model="project_modal_data.dates.real.report[0]" lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
            <div class="col-md-4">
              <date-picker v-model="project_modal_data.dates.real.report[1]" lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h3>Назначенная бригада</h3>
            </div>
            <div class="col-md-12">
              <multiselect  v-model="project_modal_data.group" placeholder="Назначьте бригаду" label="name" :searchable="true" track-by="id" :options="sgroups"></multiselect>
            </div>
          </div>
        </div>



        <div slot="footer">
          <button class="modal-default-button btn btn-success" v-if="action == 'add'" @click="addProject()">
            Добавить
          </button>
          <button class="modal-default-button btn btn-success" v-if="action == 'edit'" @click="saveProject()">
            Сохранить
          </button>
          <button class="modal-default-button btn btn-default" @click="showModal = false">
            Закрыть
          </button>
        </div>
      </modal>

    </div>
      </div>
    </div>

<?php

require $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php';
