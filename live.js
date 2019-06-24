// compare func for sorted arrays
function isEqualArray( arr1, arr2, _field ) {
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
}

function findGroup( needle, haystask ) {
  for( var i=0, cnt = haystask.length; i < cnt; i++  ) {
    var finded = isEqualArray( needle, haystask[i].workers, 'name' )

    if ( finded ) {
      return i
    }
  }

  return -1
}

var schema = [{"id":"1","content":"\u041f\u0440\u043e\u0435\u043a\u0442 1","workers":[{"id":"1","name":"\u0418\u0432\u0430\u043d\u043e\u0432 \u0418\u0432\u0430\u043d"},{"id":"4","name":"\u041f\u0435\u0442\u0440\u043e\u0432 \u041f\u0435\u0442\u0440"}],"group":"1","tasks":[]},{"id":"2","content":"\u041f\u0440\u043e\u0435\u043a\u0442 2","workers":[{"id":"1","name":"\u0418\u0432\u0430\u043d\u043e\u0432 \u0418\u0432\u0430\u043d"},{"id":"7","name":"\u0415\u0444\u0438\u043c\u043e\u0432 \u0415\u0444\u0438\u043c"},{"id":"8","name":"\u041a\u0438\u0440\u0438\u043b\u043b\u043e\u0432 \u041a\u0438\u0440\u0438\u043b\u043b"}],"group":"2","tasks":[]},{"id":"3","content":"\u041f\u0440\u043e\u0435\u043a\u0442 3","workers":[{"id":"5","name":"\u0424\u043e\u043c\u0438\u043d \u0424\u043e\u043c\u0430"},{"id":"3","name":"\u0415\u0433\u043e\u0440\u043e\u0432 \u0415\u0433\u043e\u0440"},{"id":"6","name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440\u043e\u0432 \u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440"}],"group":"3","tasks":[]},{"id":"4","content":"\u041f\u0440\u043e\u0435\u043a\u0442 4","workers":[{"id":"2","name":"\u0424\u0435\u0434\u043e\u0440\u043e\u0432 \u0424\u0435\u0434\u043e\u0440"},{"id":"7","name":"\u0415\u0444\u0438\u043c\u043e\u0432 \u0415\u0444\u0438\u043c"}],"group":"4","tasks":[]},{"id":"5","content":"\u041f\u0440\u043e\u0435\u043a\u0442 5","workers":[{"id":"6","name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440\u043e\u0432 \u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440"},{"id":"3","name":"\u0415\u0433\u043e\u0440\u043e\u0432 \u0415\u0433\u043e\u0440"},{"id":"5","name":"\u0424\u043e\u043c\u0438\u043d \u0424\u043e\u043c\u0430"}],"group":"5","tasks":[{"id":"1","content":"\u0417\u0430\u0434\u0430\u0447\u0430 5","id_project":"5","start":"1971-01-01","end":"1971-01-01","group":"5","type":"background","subtype":"real"},{"id":"2","content":"\u0414\u043e\u043f\u0443\u0441\u043a","id_project":"5","start":"1971-01-01","end":"1971-01-01","group":"5","type":"range","subtype":"real"},{"id":"3","content":"\u0414\u043e\u043f\u0443\u0441\u043a","id_project":"5","start":"1971-01-01","end":"1971-01-01","group":"5","type":"range","subtype":"contract"},{"id":"4","content":"\u0420\u0430\u0431\u043e\u0442\u0430","id_project":"5","start":"1971-01-01","end":"1971-01-01","group":"5","type":"range","subtype":"real"},{"id":"5","content":"\u0420\u0430\u0431\u043e\u0442\u0430","id_project":"5","start":"1971-01-01","end":"1971-01-01","group":"5","type":"range","subtype":"contract"},{"id":"6","content":"\u041e\u0442\u0447\u0435\u0442","id_project":"5","start":"1971-01-01","end":"1971-01-01","group":"5","type":"range","subtype":"real"},{"id":"7","content":"\u041e\u0442\u0447\u0435\u0442","id_project":"5","start":"1971-01-01","end":"1971-01-01","group":"5","type":"range","subtype":"contract"}]},{"id":"8","content":"\u0417\u0430\u0434\u0430\u0447\u0430 8","workers":[{"id":"4","name":"\u041f\u0435\u0442\u0440\u043e\u0432 \u041f\u0435\u0442\u0440"},{"id":"6","name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440\u043e\u0432 \u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440"}],"group":"8","tasks":[{"id":"8","content":"\u0417\u0430\u0434\u0430\u0447\u0430 8","id_project":"8","start":"1971-01-01","end":"1971-02-01","group":"8","type":"background","subtype":"real"},{"id":"9","content":"\u0414\u043e\u043f\u0443\u0441\u043a","id_project":"8","start":"1971-01-01","end":"1971-02-01","group":"8","type":"range","subtype":"real"},{"id":"10","content":"\u0414\u043e\u043f\u0443\u0441\u043a","id_project":"8","start":"1971-01-01","end":"1971-02-01","group":"8","type":"range","subtype":"contract"},{"id":"11","content":"\u0420\u0430\u0431\u043e\u0442\u0430","id_project":"8","start":"1971-02-02","end":"1971-08-08","group":"8","type":"range","subtype":"real"},{"id":"12","content":"\u0420\u0430\u0431\u043e\u0442\u0430","id_project":"8","start":"1971-02-02","end":"1971-08-18","group":"8","type":"range","subtype":"contract"},{"id":"13","content":"\u041e\u0442\u0447\u0435\u0442","id_project":"8","start":"1971-08-09","end":"1971-08-09","group":"8","type":"range","subtype":"real"},{"id":"14","content":"\u041e\u0442\u0447\u0435\u0442","id_project":"8","start":"1971-08-19","end":"1971-08-19","group":"8","type":"range","subtype":"contract"}]}]

for ( var i = 0, cnt = schema.length; i < cnt; i++ ) {
  schema[i].workers.sort( function(v1, v2) { return v1.id - v2.id } )
}

var groups = []
groups.push({
  id: groups.length,
  workers: schema[0].workers
})

for ( var i = 0, cnt = schema.length; i < cnt; i++ ) {
  var group_pos = findGroup( schema[i].workers, groups ),
      group_id  = -1

  if ( group_pos !== -1 ) {
    group_id = groups[ group_pos ].id
  } else {
    group_id = groups.length
    groups.push({
      id: group_id,
      workers: schema[i].workers
    })
  }

  schema[i].group = group_id
}

console.log( groups )
console.log( "----" )
console.log( schema )
