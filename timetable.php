<?
  require $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php';
?>
        
        <div id="app">
      <input type="hidden" name="view" value="table">

      <div  v-show=" view == 'table' ">
        <div class="table-wrapper">
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
              <input type="text" v-model="task_name" class="form-control">
            </div>
          </div>

          <div class="row dates-row">
            <div class="col-md-4">
              Сроки
            </div>
            <div class="col-md-8">
              <date-picker v-model="dates.task_time" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h3>Договорные сроки</h3>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Допуск
            </div>
            <div class="col-md-8">
              <date-picker v-model="dates.contract.admittance" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Проведение работ
            </div>
            <div class="col-md-8">
              <date-picker v-model="dates.contract.work" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Сдача технических отчетов
            </div>
            <div class="col-md-8">
              <date-picker v-model="dates.contract.report" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
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
              <date-picker v-model="dates.real.admittance" range lang="ru" format="YYYY-MM-DD" valueType="'date'" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Проведение работ
            </div>
            <div class="col-md-8">
              <date-picker v-model="dates.real.work" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Сдача технических отчетов
            </div>
            <div class="col-md-8">
              <date-picker v-model="dates.real.report" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h3>Назначенные сотрудники</h3>
            </div>
            <div class="col-md-12">
              <multiselect  v-model="susers" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="id" :options="users" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
            </div>
          </div>
        </div>



        <div slot="footer">
          <button class="modal-default-button btn btn-success" @click="showModal = false">
            Добавить
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
