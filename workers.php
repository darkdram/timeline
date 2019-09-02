<?
  require $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php';
?>
        
    <div id="app">
      <input type="hidden" name="view" value="workers">

      <div  v-show=" view == 'workers' ">
        <h2>Список работников</h2>
        <ul class="workers" v-cloak>
          <li v-for="worker in users">
            {{ worker.name }}
            <i @click="removeWorker(worker.id, worker.name)" class="removeBtn">x</i>
          </li>
        </ul>
        <button class="modal-default-button btn btn-success" @click="action = 'add'; showWorkerModal = true">
            Добавить
        </button>
<!--         <button class="modal-default-button btn btn-success" @click="action = 'edit'; showWorkerModal = true">
            Изменить
        </button> -->
      </div>

      <modal v-if="showWorkerModal" @close="showWorkerModal = false" v-cloak>
        <!-- <input type="text" class="datetime"> -->
        <h3 slot="header">{{ action_worker_label }}</h3>

        <div slot="body">
          <div class="row dates-row">
            <div class="col-md-4">
              ФИО работника
            </div>
            <div class="col-md-4">
              <input type="text" name="worker_name" v-model="worker_name">
            </div>
          </div>
        </div>

        <div slot="footer">
          <button class="modal-default-button btn btn-success" v-if="action == 'add'" @click="addWorker()">
            Добавить
          </button>
          <button class="modal-default-button btn btn-success" v-if="action == 'edit'" @click="showWorkerModal = false">
            Сохранить
          </button>
          <button class="modal-default-button btn btn-success" @click="showWorkerModal = false">
            Отмена
          </button>
        </div>
      </modal>

    </div>

<?php

require $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php';
