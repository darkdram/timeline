Vue.component('multiselect', VueMultiselect.default)
// Vue.component( 'date-picker' , DatePicker )
Vue.use( DatePicker )

Vue.component('modal', {
  template: '#modal-template'
})

Vue.component('task-table', {
  props: ['tasks'],
  template: '#tbl',
  mounted: function() {
    var vm = this

    if ( vm.tasks ) {
      vm.tasks.forEach(function(el, idx){
        if ( el.subtype && el.subtype ) {
          // console.log( el, el.type, el.ttype )
          // console.log( vm, vm.dates, el.type, vm.dates[ el.type ]  )
          // console.log( el.type, el.ttype, vm.dates['real']  )
          if ( vm.dates[ el.subtype ] && vm.dates[ el.subtype ][ el.ttype ] ) {
            console.log('ok')
            vm.dates[ el.subtype ][ el.ttype ]['start'] = moment(el.start, 'YYYY-MM-DD').format('DD.MM')
            vm.dates[ el.subtype ][ el.ttype ]['end'] = moment(el.end, 'YYYY-MM-DD').format('DD.MM')
          }
        } 
      })
    }

  },
  data: function() {
    return {
      dates: {
        contract: {
          report: {
            start: '-',
            end: '-'
          },
          admittance: {
            start: '-',
            end: '-'
          },
          work: {
            start: '-',
            end: '-'
          }
        },
        real: {
          report: {
            start: '-',
            end: '-'
          },
          admittance: {
            start: '-',
            end: '-'
          },
          work: {
            start: '-',
            end: '-'
          }
        }
      }
    }
  }
})

var app = new Vue({
  el: '#app',
  data: {
    view: 'timeline',
    tasks: [],
    groups: [],
    sgroups:[],
    groupsTasksCounts: [],
    groupsMaxTask: 0,
    timeline: null,
    project_modal_data: {
      title: '',
      dates: {
        contract: {
          work: ['0000-00-00','0000-00-00'],
          report: '0000-00-00'
        },
        real: {
          work:   ['0000-00-00','0000-00-00'],
          adm:    ['0000-00-00','0000-00-00'],
          report: ['0000-00-00','0000-00-00']
        }
      },
      group: {
        id: -1,
        name: ''
      }
    },
    groups_modal_data: {
      title: '',
      workers: []
    },
    users: [],
    susers: [],
    task_name: '',
    worker_name: '',
    worker_id: '',
    sched: null,
    dates: {
      task_time: [],
      contract: {
        report: ['0000-00-00','0000-00-00'],
        work: ['0000-00-00','0000-00-00']
      },
      real: {
        report: ['0000-00-00','0000-00-00'],
        admittance: ['0000-00-00','0000-00-00'],
        work: ['0000-00-00','0000-00-00']
      }
    },
    datepickerSelected: false,
    action: 'add', // edit
    showModal: false,
    showWorkerModal: false,
    notBeforeV: ''
  },
  computed: {
    action_label: function() {
      var vm = this,
        label = ''

      if ( vm.action == 'add' ) {
        label = 'Добавление задачи'
      }  else if ( vm.action == 'edit' ) {
        label = 'Редактирование задачи'
      }

      return label
    },
    action_worker_label: function() {
      var vm = this,
        label = ''

      if ( vm.action == 'add' ) {
        label = 'Добавление работника'
      }  else if ( vm.action == 'edit' ) {
        label = 'Редактирование работника'
      }

      return label
    }
  },
  watch: {
    tasks: function( _tasks ) {
      if ( this.timeline !== null )
        this.timeline.setItems( _tasks )
    },
    groups: function( _groups ) {
      if ( this.timeline !== null )
        this.timeline.setGroups( _groups )
    }
  },
  mounted: function() {
    var vm = this

    var _view = $('input[name=view]').val()

    vm.view = _view

    vm.fetchTimelineInfo()
    vm.fetchWorkersList()
    vm.fetchGroupsList()

    // $('.datetime').datepicker({
    //   range: true,
    //   multipleDatesSeparator: " - ",
    //   onSelect: function(formattedDate, date, inst) {
    //     console.log(formattedDate, date, inst)
    //   }
    // })
  
  },
  methods: {
    isEqualArray: function( arr1, arr2, _field ) {
      if ( arr1.length !== arr2.length )
        return false

      for (var i = 0, cnt = arr1.length; i < cnt; i++) {
        if ( _field !== undefined ) {
          if ( arr1[i][ _field ] !== arr2[i][ _field ] ) {
            return false
          }
        } else {
          if ( arr1[i] !== arr2[i] ) {
            return false
          }
        }
      }

      return true
    },
    addWorker: function() {
      var vm = this

      $.ajax({
        method: 'POST',
        url: '/data/addWorker.php',
        data: JSON.stringify( { name: vm.worker_name } ),
        success: function(res) {
          // console.log( res )
          var _res = res.status == 'success' ? 'Работник добавлен' : 'Не удалось добавить работника'
          // alert( _res )
          vm.closeWorkerModal()
          vm.fetchWorkersList()
        }
      })
    },
    editWorker: function( _id, _name ) {
      var vm = this

      vm.worker_id = _id
      vm.worker_name = _name
      vm.showWorkerModal = true
    },
    saveWorker: function() {
      var vm = this

      $.ajax({
        method: 'POST',
        url: '/data/saveWorker.php',
        data: JSON.stringify( { id: vm.worker_id, name: vm.worker_name } ),
        success: function(res) {
          // console.log( res )
          var _res = res.status == 'success' ? 'Работник добавлен' : 'Не удалось добавить работника'
          // alert( _res )
          vm.closeWorkerModal()
          vm.fetchWorkersList()
        }
      })
    },
    removeWorker: function( worker_id, worker_name ) {
      var vm = this
      if ( confirm("Вы действительно хотите удалить сотрудника \"" + worker_name + "\" ?" ) ) {
        $.ajax({
          method: 'POST',
          url: '/data/removeWorker.php',
          data: JSON.stringify( { worker_id: worker_id } ),
          success: function(res) {
            // console.log( res )
            alert( res.message )
            vm.fetchWorkersList()
          }
        })
      }
    },
    closeWorkerModal: function() {
      var vm = this

      vm.worker_id = ''
      vm.worker_name = ''
      vm.showWorkerModal = false
    },
    removeGroup: function( group_id, group_name ) {
      var vm = this
      if ( confirm("Вы действительно хотите удалить бригаду \"" + group_name + "\" ?" ) ) {
        $.ajax({
          method: 'POST',
          url: '/data/removeGroup.php',
          data: JSON.stringify( { group_id: group_id } ),
          success: function(res) {
            // console.log( res )
            alert( res.message )
            vm.fetchGroupsList()
          }
        })
      }
    },
    findGroup: function( needle, haystask ) {
      var vm = this

      for( var i=0, cnt = haystask.length; i < cnt; i++  ) {
        var finded = vm.isEqualArray( needle, haystask[i].users, 'name' )

        if ( finded ) {
          return i
        }
      }

      return -1
    },
    updateTimeline: function() {
      var _ntasks = []

      for( var i =0; i < _ntasks.lenght; i++  ) {
        if ( _ntasks[i].type == 'background' ) {
          delete _ntasks[i].subgroup
        }
      }

      this.timeline.setItems(_ntasks)
    },
    fetchTimelineInfo: function() {
      var vm = this
      $.ajax({
        method: 'GET',
        url: '/data/timetable.php',
        success: function(res) {
          console.log( res )
          vm.createNewTimeline( res )
        }
      })
    },
    fetchWorkersList: function() {
      var vm = this
      $.ajax({
        method: 'GET',
        url: '/data/workers_list.php',
        success: function(res) {
          console.log( res )
          vm.users = res
        }
      })
    },
    fetchGroupsList: function() {
      var vm = this
      $.ajax({
        method: 'GET',
        url: '/data/groups_list.php',
        success: function(res) {
          console.log( res )
          var _groups = Object.entries(res)
          vm.sgroups = _groups.map(function(cv){ return cv[1] })
        }
      })
    },
    formatDatesRange: function( _dates ) {
      return _dates.map(function(_date){
        if ( _date == '0000-00-00' ) {
          return _date
        }

        return moment(_date).format('YYYY-MM-DD')
      })
    },
    openAddProject: function() {
      this.showModal = false
    },
    addProject: function() {
      var vm = this,
          _query = {
            project_name: '',
            dates: {},
            group: -1
          }

      _query.project_name   = vm.project_modal_data.title
      _query.group          = vm.project_modal_data.group.id
      _query.dates.contract = {
        start: '0000-00-00',
        end: '0000-00-00',
        report: '0000-00-00'
      }

      // console.log(1)

      _query.dates.real = {
        work: {
          start: '0000-00-00',
          end:   '0000-00-00'
        },
        adm: {
          start: '0000-00-00',
          end:   '0000-00-00'
        },
        report: {
          end:  '0000-00-00',
          send: '0000-00-00'
        },
      }

      console.log(2)


      // console.log(21)
      if ( typeof vm.project_modal_data.dates.contract.work[0] == 'object' )
        _query.dates.contract.start = moment( vm.project_modal_data.dates.contract.work[0] ).format('YYYY-MM-DD')

      // console.log(22)
      if ( typeof vm.project_modal_data.dates.contract.work[1] == 'object' )
        _query.dates.contract.end = moment( vm.project_modal_data.dates.contract.work[1] ).format('YYYY-MM-DD')

      if ( typeof vm.project_modal_data.dates.contract.report == 'object' )
        _query.dates.contract.report = moment( vm.project_modal_data.dates.contract.report ).format('YYYY-MM-DD')


      // console.log(23)
      if ( typeof vm.project_modal_data.dates.real.work[0] == 'object' )
        _query.dates.real.work.start = moment( vm.project_modal_data.dates.real.work[0] ).format('YYYY-MM-DD')

      // console.log(24)
      if ( typeof vm.project_modal_data.dates.real.work[1] == 'object' )
        _query.dates.real.work.end = moment( vm.project_modal_data.dates.real.work[1] ).format('YYYY-MM-DD')

      // console.log(25)
      if ( typeof vm.project_modal_data.dates.real.adm[0] == 'object' )
        _query.dates.real.adm.start = moment( vm.project_modal_data.dates.real.adm[0] ).format('YYYY-MM-DD')

      // console.log(26)
      if ( typeof vm.project_modal_data.dates.real.adm[1] == 'object' )
        _query.dates.real.adm.end = moment( vm.project_modal_data.dates.real.adm[1] ).format('YYYY-MM-DD')

      // console.log(27)
      if ( typeof vm.project_modal_data.dates.real.report[0] == 'object' )
        _query.dates.real.report.end = moment( vm.project_modal_data.dates.real.report[0] ).format('YYYY-MM-DD')

      // console.log(28)
      if ( typeof vm.project_modal_data.dates.real.report[1] == 'object' )
        _query.dates.real.report.send = moment( vm.project_modal_data.dates.real.report[1] ).format('YYYY-MM-DD')
      // console.log(29)


      // console.log(3)
      $.ajax({
        method: 'POST',
        // url: '/data/printRes.php',
        url: '/data/addProject.php',
        data: JSON.stringify( _query ),
        success: function( res ) {
          alert( res.message )
          console.log( res )
          if ( res.status == 'success' ) {
            vm.showModal = false
            vm.fetchTimelineInfo();
          }
        }
      })

    },
    addGroup: function() {
      var vm = this,
        _query = {
          title:   vm.groups_modal_data.title,
          workers: vm.groups_modal_data.workers
        }


      $.ajax({
        method: 'POST',
        // url: '/data/printRes.php',
        url: '/data/addGroup.php',
        data: JSON.stringify( _query ),
        success: function( res ) {
          alert( res.message )
          console.log( res )
          if ( res.status == 'success' ) {
            vm.showWorkerModal = false
            vm.fetchGroupsList();
          }
        }
      })
    },
    clearProjectModal:function () {
      this.project_modal_data = {
        title: '',
        dates: {
          contract: {
            work: ['0000-00-00','0000-00-00'],
            report: '0000-00-00'
          },
          real: {
            work:   ['0000-00-00','0000-00-00'],
            adm:    ['0000-00-00','0000-00-00'],
            report: ['0000-00-00','0000-00-00']
          }
        },
        group: {
          id: -1,
          name: ''
        }
      }
    },

    saveProject: function() {
      this.showModal = false
    },
    createTask: function() {
      var vm = this

      var _data = {
        action: vm.action,
        task: {
          name: vm.task_name,
          time: vm.formatDatesRange( vm.dates.task_time )
        },
        times: {
          real: {
            admittance: vm.formatDatesRange( vm.dates.real.admittance ),
            work:       vm.formatDatesRange( vm.dates.real.work ),
            report:     vm.formatDatesRange( vm.dates.real.report )
          },
          contract: {
            admittance: vm.formatDatesRange( vm.dates.contract.admittance ),
            work:       vm.formatDatesRange( vm.dates.contract.work ),
            report:     vm.formatDatesRange( vm.dates.contract.report )
          }
        }
      }

      $.ajax({
        method: 'POST',
        // url: '/data/printRes.php',
        url: '/data/addTask.php',
        data: JSON.stringify(_data),
        success: function( res ) {
          console.log( res )
        }
      })
    },
    createNewTimeline: function( schedule ) {
      var vm = this,
          cnt = schedule.length

        console.log( schedule )

      for ( var i = 0; i < cnt; i++ ) {
        schedule[i].users.sort( function(v1, v2) { return v1.id - v2.id } )
      }

      var grps = []
      grps.push({
        id: grps.length + 1,
        content: grps.length + 1 + '',
        users: schedule[0].users
      })

      for ( var i = 0; i < cnt; i++ ) {
        var group_pos = vm.findGroup( schedule[i].users, grps ),
            group_id  = -1

        if ( group_pos !== -1 ) {
          group_id = grps[ group_pos ].id
        } else {
          group_id = grps.length + 1
          grps.push({
            id: group_id,
            content: grps.length + 1 + '',
            users: schedule[i].users
          })
        }

        schedule[i].group = group_id
      }

      var _tasks = [  ]
      for ( var i = 0; i < cnt; i++ ) {
        var jcnt = schedule[i].tasks.length
        if ( schedule[i].tasks && jcnt > 0 ) {
          var jsched = schedule[i].tasks
          for ( var j = 0, jcnt = jcnt; j < jcnt; j++ ) {
            var color = ''

            if ( jsched[j].type == 'background' ) {
              color = '#40BF6A'
            } else {
              if ( jsched[j].subtype == 'real' ) {
                color = 'red'
              } else {
                color = 'yellow'
              }
            }

            var _new_task = {
              id: parseInt( jsched[j].id ) ,
              content: jsched[j].content,
              group: parseInt( schedule[i].group ),
              id_project: parseInt( jsched[j].id_project ),
              type: jsched[j].type,
              start: jsched[j].start,
              end: jsched[j].end,
              subtype: jsched[j].subtype,
              style: 'background-color: ' + color + ';'
            }

            if ( jsched[j].type !== 'background' ) {
              _new_task.subgroup = 'task' + jsched[j].group + '_' + jsched[j].subtype
            }

            _tasks.push( _new_task )
          }
        }
      }

      var _groupsTasksCounts = []
      grps.forEach(function(grp){
        var curr_gtc_idx = _groupsTasksCounts.length
        _groupsTasksCounts.push({
          id: grp.id,
          cnt: 0
        })

        schedule.forEach(function( _tsk ){
          if ( _tsk.group == grp.id ) {
            _groupsTasksCounts[ curr_gtc_idx ].cnt++
          }
        })
      })

      vm.sched = schedule

      vm.tasks = _tasks
      vm.groups = grps
      vm.groupsTasksCounts = _groupsTasksCounts

      if ( vm.view == 'timeline' ) {

        if ( vm.timeline !== null ) {
          vm.timeline.setItems( _tasks )
          vm.timeline.setGroups( grps )
        } else {
          var container = document.getElementById('visualization');

          var items  = new vis.DataSet(vm.tasks),
              groups = new vis.DataSet(vm.groups)

          var options = {
            locale: "ru",
            editable: {
              add: true,          // add new items by double tapping
              updateTime: false,   // drag items horizontally
              updateGroup: false, // drag items from one group to another
              remove: false,      // delete an item by tapping the delete button top right
              overrideItems: true // allow these options to override item.editable
            },
            groupEditable: false,
            stack: false,
            groupTemplate: function(group){
              var container = document.createElement('div');

              group.users.forEach(function(person){
                 var wrap = document.createElement('div')
                 wrap.innerHTML = '<a href="/users.php?id=' + person.id +'">' + person.name + '</a>'
                 container.insertAdjacentElement('beforeend', wrap);
              })

              return container;
            },

            groupOrderSwap: function (a, b, groups) {
              var v = a.value;
              a.value = b.value;
              b.value = v;
            },
            onAdd: function (item, callback){
              // console.log( 'onAdd', item )
              vm.showModal = true
              vm.action = 'add'
            },
            onUpdate: function (item, callback) {
              // console.log( 'onUpdate', item )
              vm.showModal = true
              vm.action = 'edit'
            },
            orientation: 'both',
          }

          vm.timeline = new vis.Timeline(container);
          vm.timeline.setOptions(options);
          vm.timeline.setGroups(groups);
          vm.timeline.setItems(items);
        }
      }
    },
    addTag (newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000)),
        status: 'new'
      }
      this.options.push(tag)
      this.value.push(tag)
    },
    groupSelectLabel: function(el) {
      return el.id + ' - ' + el.name
    }


  }
})