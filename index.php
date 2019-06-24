<html>
  <head>
    <title>Hellfire</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel='stylesheet' href='/assets/vendor/vis/dist/vis.min.css'>
    <link rel='stylesheet' href='/assets/vendor/vis/dist/vis-timeline-graph2d.min.css'>
    <link rel="stylesheet" href="/assets/vendor/datepicker.min.css">
    <link rel='stylesheet' href='/assets/css/main.css' />
  </head>

  <body>
    <div id="app">
      <a href="#" @click="view = 'table'">Таблица</a>
      <a href="#" @click="view = 'timeline'">Таймлайн</a>
      <hr>
      <input type="text" class="datetime">

      <table border="1" v-show=" view == 'table' ">
        <tr v-for="group in groups">
          <td>
            <template v-for="user in group.users">
              <a :href="'/user.php?id=' + user.id">{{ user.name  }}</a> <br>
            </template>
          </td>
        </tr>
      </table>

      <div id="visualization" v-show=" view == 'timeline' "></div>

      <!-- Button trigger modal -->
      <div style="display: none">
        <button type="button" class="btn btn-primary btn-lg showModalCreateTask" data-toggle="modal" data-target="#myModal">
          Launch demo modal
        </button>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">{{ modal_data.modal_header }}</h4>
            </div>
            <div class="modal-body">
              <input type="text" class="datetime">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              <button type="button" class="btn btn-primary">Сохранить</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="/assets/vendor/jquery-3.4.1.min.js"></script>
    <script src="/assets/vendor/moment.min.js"></script>
    <script src="/assets/vendor/vis/dist/vis.js"></script>
    <script src="/assets/vendor/vue/dist/vue.js"></script>
    <script src="/assets/vendor/datepicker.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <script src="/assets/js/main.js"></script>

    <!--
      <script src="/assets/js/vue/dist/vue.js"></script>
      <script src="/assets/js/vue/dist/vue-router.js"></script>
    -->
  </body>
</html>