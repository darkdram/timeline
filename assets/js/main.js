var app = new Vue({
  el: '#app',
  data: {
    view: 'timeline',
    tasks: [],
    groups: [],
    groupsMaxTask: 0,
    timeline: null,
    modal_data: {
      modal_header: 'Добавление задачи'
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

    // items.remove(1)
    // groups.remove(1)

    // vm.tasks.length = 0
    // vm.groups.length = 0

    $('.datetime').datepicker({
      range: true,
      multipleDatesSeparator: " - ",
      onSelect: function(formattedDate, date, inst) {
        console.log(formattedDate, date, inst)
      }
    })
  
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

        // console.log( group_id )

        schedule[i].group = group_id
        // console.log( schedule[i].group )
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
              content: jsched[j].content + schedule[i].group,
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

            // console.log( _new_task )
            _tasks.push( _new_task )
          }
        }
      }

      // vm.tasks.length = 0


      vm.tasks = _tasks
      vm.groups = grps

      if ( vm.timeline !== null ) {
        // vm.groups.length = 0
        vm.timeline.setItems( _tasks )
        vm.timeline.setGroups( grps )
      } else {
        // DOM element where the Timeline will be attached
        var container = document.getElementById('visualization');

        // Create a DataSet (allows two way data-binding)

        var items = new vis.DataSet(vm.tasks)
        var groups = new vis.DataSet(vm.groups)
        // Configuration for the Timeline
        var options = {
          locale: "ru",
          editable: true,
          groupEditable: true,
          stack: false,
          groupTemplate: function(group){
            container = document.createElement('div');

            group.users.forEach(function(element) {
              // console.log( element )
              brigada_user = document.createElement('p');
              brigada_user.style.cssText = "font-size: 11px;"
              brigada_user.innerHTML = element.name;
              container.insertAdjacentElement('beforeend',brigada_user);
            });

            return container;
          },

          groupOrderSwap: function (a, b, groups) {
            var v = a.value;
            a.value = b.value;
            b.value = v;
          },

          onAdd: function (item, callback){
            console.log( 'onAdd', item )
            // $('#exampleModalCenter').on('shown.bs.modal', function () {
            //   $('.editor_input input[name=content]').val(item.content)
            // });
            // $('#exampleModalCenter').modal();
            // callback(item);
          },

          onUpdate: function (item, callback) {
            console.log( 'onUpdate', item )
            // $('#exampleModalCenter').on('shown.bs.modal', function () {
            //   $('.editor_input input[name=content]').val(item.content)
            // });
            // $('#exampleModalCenter').modal();
            // callback(item);
          },
          orientation: 'both',
        }

        // Create a Timeline
        vm.timeline = new vis.Timeline(container);
        vm.timeline.setOptions(options);
        vm.timeline.setGroups(groups);
        vm.timeline.setItems(items);
      }
    }
  }
})