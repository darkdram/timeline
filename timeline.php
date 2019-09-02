<?
  require $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php';
?>

    <div id="app">
      <input type="hidden" name="view" value="timeline">
      <h2>Таймлайн объектов</h2>

      <div  v-show=" view == 'timeline' ">
        <div id="visualization"></div>
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
<?php

require $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php';
