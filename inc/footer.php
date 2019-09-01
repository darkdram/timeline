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
      <table border="1" class="inner-table">
        <tr>
          <td style="width: 250px">&nbsp;</td>
          <td style="width: 250px">&nbsp;</td>
          <td style="width: 250px">{{ dates.contract.report.start }}</td>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="/assets/js/main.js"></script>

    <!--
      <script src="/assets/js/vue/dist/vue.js"></script>
      <script src="/assets/js/vue/dist/vue-router.js"></script>
    -->
  </body>
</html>