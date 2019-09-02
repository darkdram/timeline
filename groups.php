<?
  require $_SERVER['DOCUMENT_ROOT'] . '/inc/header.php';
?>
        
    <div id="app">
      <input type="hidden" name="view" value="groups">

      <div  v-show=" view == 'groups' ">
        <h2>Список бригад</h2>
        <ul class="groups" v-cloak>
          <li v-for="group in sgroups">
            {{ group.name }}
            <i @click="removeGroup(group.id, group.name)" class="removeBtn">x</i>
          </li>
        </ul>

        <button class="modal-default-button btn btn-success" @click="action = 'add'; showWorkerModal = true">
            Добавить
        </button>
<!--         <button class="modal-default-button btn btn-success" @click="action = 'edit'; showWorkerModal = true">
            Изменить
        </button> -->
      </div>


      <!-- use the modal component, pass in the prop -->
      <modal v-if="showWorkerModal" @close="showWorkerModal = false" v-cloak>
        <!-- <input type="text" class="datetime"> -->
        <h3 slot="header">Изменение бригады</h3>

        <div slot="body">

          <div class="row">
            <div class="col-md-12">
              <h3>Название бригады</h3>
            </div>
            <div class="col-md-12">
              <input type="text" name="group_name" v-model="groups_modal_data.title">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h3>Назначенные сотрудники</h3>
            </div>
            <div class="col-md-12">
              <multiselect  v-model="groups_modal_data.workers" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="id" :options="users" :multiple="true" :taggable="false" @tag="addTag"></multiselect>
            </div>
          </div>
        </div>



        <div slot="footer">
          <button class="modal-default-button btn btn-success" @click="addGroup()">
            Добавить
          </button>
          <button class="modal-default-button btn btn-default" @click="showWorkerModal = false">
            Закрыть
          </button>
        </div>
      </modal>

    </div>
      </div>
    </div>

<?php

require $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php';
