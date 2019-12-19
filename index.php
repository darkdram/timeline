<?php
header('Location: /timeline.php');
die();

?>

<html>
<head>
    <title>Hellfire</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel='stylesheet' href='/assets/vendor/vis/dist/vis.min.css'>
    <link rel='stylesheet' href='/assets/vendor/vis/dist/vis-timeline-graph2d.min.css'>
    <!-- <link rel="stylesheet" href="/assets/vendor/datepicker.min.css"> -->
    <link rel="stylesheet" href="/assets/vendor/datepicker.css">
    <link rel="stylesheet" href="/assets/vendor/vue-multiselect.min.css">
    <link rel='stylesheet' href='/assets/css/main.css'/>
</head>

<body>

<div class="container-fluid">
    <div class="col-md-2" style="border: 1px solid red"><? require './inc/sidebar.php'; ?></div>
    <div class="col-md-8">

        <div id="app">
            <a href="#" @click="view = 'table'">Таблица</a>
            <a href="#" @click="view = 'timeline'">Таймлайн</a>
            <hr>

            <div v-show=" view == 'table' ">
                <table border="1" class="schedule">
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
                                <a :href="'/user.php?id=' + user.id">{{ user.name }}</a> <br>
                            </template>
                        </td>
                        <td>
                            <table border="1">
                                <tr>
                                    <td>Дог. сроки н/к/отч</td>
                                </tr>
                                <tr>
                                    <td>Допуск</td>
                                </tr>
                                <tr>
                                    <td>Проведение работ</td>
                                </tr>
                                <tr>
                                    <td>Отчеты к/отпр</td>
                                </tr>
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


            <div v-show=" view == 'timeline' ">
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

                    <div class="row dates-row">
                        <div class="col-md-4">
                            Сроки
                        </div>
                        <div class="col-md-8">
                            <date-picker v-model="dates.task_time" range lang="ru" format="YYYY-MM-DD"
                                         range-separator="-" confirm></date-picker>
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
                            <date-picker v-model="dates.contract.admittance" range lang="ru" format="YYYY-MM-DD"
                                         range-separator="-" confirm></date-picker>
                        </div>
                    </div>
                    <div class="row dates-row">
                        <div class="col-md-4">
                            Проведение работ
                        </div>
                        <div class="col-md-8">
                            <date-picker v-model="dates.contract.work" range lang="ru" format="YYYY-MM-DD"
                                         range-separator="-" confirm></date-picker>
                        </div>
                    </div>
                    <div class="row dates-row">
                        <div class="col-md-4">
                            Сдача технических отчетов
                        </div>
                        <div class="col-md-8">
                            <date-picker v-model="dates.contract.report" range lang="ru" format="YYYY-MM-DD"
                                         range-separator="-" confirm></date-picker>
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
                            <date-picker v-model="dates.real.admittance" range lang="ru" format="YYYY-MM-DD"
                                         valueType="'date'" range-separator="-" confirm></date-picker>
                        </div>
                    </div>
                    <div class="row dates-row">
                        <div class="col-md-4">
                            Проведение работ
                        </div>
                        <div class="col-md-8">
                            <date-picker v-model="dates.real.work" range lang="ru" format="YYYY-MM-DD"
                                         range-separator="-" confirm></date-picker>
                        </div>
                    </div>
                    <div class="row dates-row">
                        <div class="col-md-4">
                            Сдача технических отчетов
                        </div>
                        <div class="col-md-8">
                            <date-picker v-model="dates.real.report" range lang="ru" format="YYYY-MM-DD"
                                         range-separator="-" confirm></date-picker>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Назначенные сотрудники</h3>
                        </div>
                        <div class="col-md-12">
                            <multiselect v-model="susers" tag-placeholder="Add this as new tag"
                                         placeholder="Search or add a tag" label="name" track-by="id" :options="users"
                                         :multiple="true" :taggable="true" @tag="addTag"></multiselect>
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


<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            default footer
                            <button class="modal-default-button" @click="$emit('close')">
                                OK
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>

<script type="text/x-template" id="tbl">
    <table border="1" width="100%">
        <tr>
            <td width="33%">&nbsp;</td>
            <td width="33%">&nbsp;</td>
            <td width="33%">{{ dates.contract.report.start }}</td>
        </tr>
        <tr>
            <td>{{ dates.real.admittance.start }}</td>
            <td>{{ dates.real.admittance.end }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ dates.real.work.start }}</td>
            <td>{{ dates.real.work.start }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">{{ dates.real.report.start }}</td>
            <td>{{ dates.real.report.end }}</td>
        </tr>
    </table>
</script>

<!-- <script src="/assets/vendor/locale/ru.js"></script> -->
<script src="/assets/vendor/vue/dist/vue.js"></script>
<script src="/assets/vendor/jquery-3.4.1.min.js"></script>
<script src="/assets/vendor/moment-with-locales.min.js"></script>
<script src="/assets/vendor/vis/dist/vis.js"></script>
<script src="/assets/vendor/vue-multiselect.min.js"></script>
<!-- <script src="/assets/vendor/datepicker.min.js"></script> -->
<script src="/assets/vendor/datepicker.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="/assets/js/main.js"></script>

<!--
  <script src="/assets/js/vue/dist/vue.js"></script>
  <script src="/assets/js/vue/dist/vue-router.js"></script>
-->
</body>
</html>
