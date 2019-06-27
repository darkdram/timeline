Vue.component('multiselect', VueMultiselect)
// Vue.component( 'date-picker' , DatePicker )
Vue.use( DatePicker )

Vue.component('modal', {
  template: '#modal-template'
})

var app = new Vue({
  el: '#app',
  data: {
    view: 'timeline',
    tasks: [],
    groups: [],
    groupsTasksCounts: [],
    groupsMaxTask: 0,
    timeline: null,
    modal_data: {
      modal_header: 'Добавление задачи'
    },
    users: [],
    task_name: '',
    dates: {
      task_time: [],
      contract: {
        report: ['0000-00-00','0000-00-00'],
        admittance: ['0000-00-00','0000-00-00'],
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
    showModal: false
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

    vm.fetchTimelineInfo()

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

      for( var i =0; i < _ntasks.length; i++  ) {
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
    formatDatesRange: function( _dates ) {
      return _dates.map(function(_date){
        if ( _date == '0000-00-00' ) {
          return _date
        }

        return moment(_date).format('YYYY-MM-DD')
      })
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
        url: '/data/printRes.php',
        data: JSON.stringify(_data),
        success: function( res ) {
          console.log( res )
        }
      })
    },
    createNewTimeline: function( schedule ) {
      var vm = this,
          cnt = schedule.length

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

      vm.tasks = _tasks
      vm.groups = grps
      vm.groupsTasksCounts = _groupsTasksCounts

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
            updateTime: true,   // drag items horizontally
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
            console.log( 'onAdd', item )
            vm.showModal = true
            vm.action = 'add'
          },
          onUpdate: function (item, callback) {
            console.log( 'onUpdate', item )
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
    },
    addTag (newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000)),
        status: 'new'
      }
      this.options.push(tag)
      this.value.push(tag)
    }


  }
})