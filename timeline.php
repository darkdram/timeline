<?
  require $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php';
?>

    <div id="app">
      <input type="hidden" name="view" value="timeline">
      
      <div  v-show=" view == 'timeline' ">
        <div id="visualization"></div>
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
              <date-picker v-model="dates.contract.work" range lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>
          <div class="row dates-row">
            <div class="col-md-4">
              Сдача отчета
            </div>
            <div class="col-md-8">
              <date-picker v-model="dates.contract.report" lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
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
            <div class="col-md-4">
              <date-picker v-model="dates.real.report" lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
            <div class="col-md-4">
              <date-picker v-model="dates.real.report" lang="ru" format="YYYY-MM-DD" range-separator="-" confirm></date-picker>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h3>Назначенные сотрудники</h3>
            </div>
            <div class="col-md-12">
              <multiselect  v-model="susers" placeholder="Назначьте бригаду" label="name" :searchable="true" track-by="id" :options="sgroups"></multiselect>
            </div>
          </div>
        </div>



        <div slot="footer">
          <button class="modal-default-button btn btn-success" v-if="action == 'add'" @click="showModal = false">
            Добавить
          </button>
          <button class="modal-default-button btn btn-success" v-if="action == 'edit'" @click="showModal = false">
            Сохранить
          </button>
          <button class="modal-default-button btn btn-default" @click="showModal = false">
            Закрыть
          </button>
        </div>
      </modal>

    </div>
<?php

require $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php';
