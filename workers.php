<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php';
?>
        
    <div id="app">
      <input type="hidden" name="view" value="workers">

      <div  v-show=" view == 'workers' ">
        <h2>Список работников</h2>
        <div class="row">
          <div class="col-md-4">
            <table class="table" v-if="users.length > 0">
              <tr>
                <th colspan="7">Имя</th>
                <th colspan="3" style="text-align: center;">&nbsp;</th>
              </tr>

              <tr v-for="worker in users">
                <td  colspan="7">{{ worker.name }}</td>
                <td  colspan="3" style="text-align: center;">
                  <button type="button" class="btn btn-sm btn-warning" @click="editWorker(worker.id, worker.name)">
                    <i class="glyphicon glyphicon-pencil"></i>
                  </button>
                  
                  <button type="button" class="btn btn-sm btn-danger" @click="removeWorker(worker.id, worker.name)">
                    <i class="glyphicon glyphicon-remove"></i>
                  </button>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <button class="modal-default-button btn btn-success" @click="action = 'add'; showWorkerModal = true">
            Добавить
        </button>
      </div>

      <modal v-if="showWorkerModal" @close="showWorkerModal = false" v-cloak>
        <h3 slot="header">{{ action_worker_label }}</h3>

        <div slot="body">
          <div class="row dates-row">
            <div class="col-md-4">
              <label for="worker_name_modal">ФИО работника</label>
            </div>
            <div class="col-md-4">
              <input type="text" id="worker_name_modal" class="form-control" name="worker_name" v-model="worker_name">
            </div>
          </div>
        </div>

        <div slot="footer">
          <button class="modal-default-button btn btn-success" @click="saveWorker()">
            Сохранить
          </button>
          <button class="modal-default-button btn btn-success" @click="closeWorkerModal()">
            Отмена
          </button>
        </div>
      </modal>
    </div>

<?php

require $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php';
