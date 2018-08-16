var idbApp = (function() {
  'use strict';


  if (!('indexedDB' in window)) {
    console.log('This browser doesn\'t support IndexedDB');
   }


  var dbPromise = idb.open('products', 1, function(upgradeDB) {
  var store = upgradeDB.createObjectStore('owners', {
          keyPath: 'id'
        });
    store.createIndex('id', 'id', {unique: true});
    store.createIndex('entryOffline', 'entryOffline', {unique: false});

      });


  function fetchLink(link){
  fetch(link, {credentials: 'same-origin', redirect: 'follow'}).then(function(response){
    return
   }).catch(function(error) {
        console.log('Registration failed with ' + error);
    });
  }


function storePost(){
  if (navigator.onLine==false){
        var formData = new FormData(document.getElementById('myForm'));
        var arr = {id: 0};

        for(var pair of formData.entries()) {
           console.log(pair[0]+ ': '+ pair[1]);
           arr[pair[0]] =  pair[1];
        }
        arr.entryOffline = "1";
          dbPromise.then(function(db) {
            var tx = db.transaction('owners', 'readwrite');
            var store = tx.objectStore('owners');
            var myIndex =store.index('id');
            myIndex.getAllKeys().then(function(keys){
              var arrayOfNumbers = keys.map(Number);
              var maxindex=arrayOfNumbers[arrayOfNumbers.length-1];
              arr.id = String(maxindex+1);
              console.log('No network, caching record');
              return store.add(arr);
            })
          })
   } else{
        return
   }
}


function deletePost(htmlElement){
  if (navigator.onLine==false){
       var arr = {};
       arr.id=htmlElement.href.substr(htmlElement.href.search("=")+1);
       console.log('id is '+arr.id);
        arr.entryOffline = "2";
          dbPromise.then(function(db) {
            var tx = db.transaction('owners', 'readwrite');
            var store = tx.objectStore('owners');
            var deletedData=store.get(arr.id);
            if(deletedData=='undefined'){
              return
            }
            deletedData.then(function(data){
              console.log('data stored');
              data.entryOffline = arr.entryOffline;
              return store.put(data);
            })

          })
   } else{
        return
   }
}

function handleEdit(htmlElement){
  var arr = {};
  if(navigator.onLine==false){
    arr.id=htmlElement.href.substr(htmlElement.href.search("=")+1);
    htmlElement.setAttribute('href', 'edit_owners_offline.php');
    console.log('id is '+arr.id);
    arr.entryOffline = "-1";
    dbPromise.then(function(db) {
        var tx = db.transaction('owners', 'readwrite');
        var store = tx.objectStore('owners');
       var editData=store.get(arr.id);
        if(editData=='undefined'){
          return
        }
          editData.then(function(data){
          console.log('data stored');
          data.entryOffline = arr.entryOffline;
          return store.put(data);
        })

      })

  }else{
     return
  }
}

function editPageOnLoad(){
  if(navigator.onLine==false){
    return dbPromise.then(function(db) {
       var tx = db.transaction('owners', 'readwrite');
       var store = tx.objectStore('owners');
       var entryOffline=store.index('entryOffline');
       var offlineObjminus1 = entryOffline.getAll('-1');
       offlineObjminus1.then(function(data){
         for(var key in data[0]){
            document.getElementById(key).setAttribute('value',data[0][key]);


         }
           data[0].entryOffline='0';
           document.getElementById('entryOffline').setAttribute('value','0');

           return store.put(data[0]);
       })

     })
  }else{
     return
  }

}

function editPost(){
  var formData = new FormData(document.getElementById('myFormEdit'));
  var arr = {};
  for(var pair of formData.entries()) {
     arr[pair[0]] =  pair[1];
  }
  arr.entryOffline = "3";
  dbPromise.then(function(db) {
    var tx = db.transaction('owners', 'readwrite');
    var store = tx.objectStore('owners');
    console.log('data edited');
    return store.put(arr);
  })
}




  function createDB(){
  dbPromise.then(function(db) {
  var tx = db.transaction('owners', 'readwrite');
   var store = tx.objectStore('owners');
   var myIndex =store.index('id');
   var idbIdArr= myIndex.getAllKeys().then(function(keys){
     var arrayOfIds = keys.map(Number);
     return arrayOfIds;
   })
   var ownerobj = document.getElementById('ownerJSON').innerHTML
   var ownersJSON =  JSON.parse(ownerobj);
   for (var i=0;i<ownersJSON.length;i++) {
     ownersJSON[i].entryOffline = "0";
    }
     return Promise.all(ownersJSON.map(function(owner) {
       return idbIdArr.then(function(idarr){
                if(idarr.indexOf(owner.id)){
                  console.log('updating owner: ', owner);
                  return store.put(owner);

                }else{
                  console.log('Adding owner: ', owner);
                  return store.add(owner);
                }
       })

     })
   ).catch(function(e) {
     tx.abort();
       console.log(e);
     }).then(function() {
       console.log('All owners added successfully!');
     });
   });
  }


  function readDB(){
    return dbPromise.then(function(db) {
      var tx = db.transaction('owners', 'readonly');
      var store = tx.objectStore('owners');
      var tableVals=store.getAll();
      return tableVals;
    }).then(function(values){
      return values;
    });
  }

   function offlineEntriesObj(){
    return dbPromise.then(function(db) {
       var tx = db.transaction('owners', 'readonly');
       var store = tx.objectStore('owners');
       var entryOffline=store.index('entryOffline');
       var offlineObj1 = entryOffline.getAll('1');
       var offlineObj2 = entryOffline.getAll('2');
       var offlineObj3 = entryOffline.getAll('3');
       var promObj=[];

    return Promise.all([offlineObj1, offlineObj2, offlineObj3]).then(function(data) {
              console.log(data[0][0]);
              console.log(data[1][0]);
              console.log(data[2][0]);

              var k;
              for(k=0;k<3;k++){
                console.log(typeof(data[k][0])!='undefined');
                 if(typeof(data[k][0])!='undefined'){
                   promObj.push(data[k][0]);
                 }else{
                   continue
                 }
              }
              console.log(promObj);
              return promObj;
            });
   })
  }


    function postOfflineEntriesPromise(obj){
      if(typeof(obj)=='undefined'){
        window.location.replace("index.php");
        return
      }
    var OfflineEntriesPromise = new Promise(function (resolve, reject) {

    if(obj.length>0){

      var form = document.createElement('form');
      form.method = 'POST';
      form.id = 'form';
      form.onsubmit = deleteOfflineEntries();
      var i;
      for(i=0; i<obj.length; i++){
          console.log(obj.length);
          for (var key in obj[i]) {
              var input_key_i =  document.createElement("input");
              input_key_i.setAttribute('type',"text");
              input_key_i.setAttribute('id',key+i);
              input_key_i.setAttribute('name',key+i);
              input_key_i.value = obj[i][key];
              form.appendChild(input_key_i);
              console.log(input_key_i.value);
         }
      }
      var input_length =  document.createElement("input");
      input_length.setAttribute('type',"text");
      input_length.setAttribute('id','object_length');
      input_length.setAttribute('name','object_length');
      input_length.value = (obj.length);
      form.appendChild(input_length);
      console.log(input_length.value);

     var input_submit =  document.createElement("input");
     input_submit.setAttribute('type',"submit");
     input_submit.setAttribute('id','create');
     input_submit.setAttribute('name','create');
     console.log(input_submit.name);

     form.appendChild(input_submit);
     document.body.appendChild(form);
     resolve('success'); // fulfilled
    } else if (obj.length==0) {
      console.log('no entries to update');
      window.location.replace("index.php");
      reject('no entries to update');
    }
    });
    return OfflineEntriesPromise;
  }

  function deleteOfflineEntries(){
    return dbPromise.then(function(db) {
      var tx = db.transaction('owners', 'readwrite');
      var store = tx.objectStore('owners');
      var range = IDBKeyRange.bound('1','2');
      var offlineObj1=store.index('entryOffline').getAll('1');
      var offlineObj2=store.index('entryOffline').getAll('2');
      offlineObj1.then(function(result){
            var y=0;
            for(y=0;y<result.length;y++){
              store.delete(result[y].id);
            }
         })
         offlineObj2.then(function(result){
               var y=0;
               for(y=0;y<result.length;y++){
                 store.delete(result[y].id);
               }
            })
      });
    };


function JSONtoTable(jsondata){
var obj = JSON.parse(jsondata);
var ownersTableBody=document.getElementById('ownersTableBody');
var l;
for(l=0;l<obj.length;l++){
  if(obj[l]['entryOffline']=='2'){
    continue;
  }
  var tr = document.createElement('tr');
  for (var key in obj[l]) {
    if(key=='entryOffline'){
        continue;
      }
    var td_key_l = document.createElement('td');
    td_key_l.innerHTML=obj[l][key];
    //add links to business name
    if (key=='businessname'){
        var div = document.createElement('div');
        div.setAttribute('class',"action_links");
        var a_delete=document.createElement('a');
        a_delete.href = "delete_owners.php?id="+obj[l]['id'];
        a_delete.setAttribute("onclick","handleDelete(this);");
        a_delete.innerHTML = 'Delete';
        var a_edit=document.createElement('a');
        a_edit.href = "edit_owners.php?id="+obj[l]['id'];
        a_edit.setAttribute("onclick","idbApp.handleEdit(this);");
        a_edit.innerHTML = '  Edit';
        div.appendChild(a_delete);
        div.appendChild(a_edit);
        td_key_l.appendChild(div);
      }

      tr.appendChild(td_key_l);
      ownersTableBody.appendChild(tr);
   }
 }
 return true

}

 return {
    JSONtoTable:(JSONtoTable),
    dbPromise:(dbPromise),
    postOfflineEntriesPromise:(postOfflineEntriesPromise),
    handleEdit:(handleEdit),
    editPost:(editPost),
    editPageOnLoad:(editPageOnLoad),
    deleteOfflineEntries:(deleteOfflineEntries),
    deletePost:(deletePost),
    createDB: (createDB),
    readDB: (readDB),
    fetchLink: (fetchLink),
    storePost: (storePost),
    offlineEntriesObj: (offlineEntriesObj)
  };
})();
