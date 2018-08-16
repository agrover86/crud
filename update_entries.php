<?php include("includes/init.php"); ?>

<?php
 if(isset($_POST['create'])){
   for ($x = 0; $x < $_POST['object_length']; $x++) {
        if($_POST['entryOffline'.$x]=='1'){
        $owner = new Owner();
        $owner->businessname = $_POST['businessname'.$x];
        $owner->firstname = $_POST['firstname'.$x];
        $owner->surname = $_POST['surname'.$x];
        $owner->email = $_POST['email'.$x];
        $owner->telephone = $_POST['telephone'.$x];
        $owner->create();
      }elseif ($_POST['entryOffline'.$x]=='2') {
        $owner= Owner::find_by_id($_POST['id'.$x]);
        $owner->delete();
      }elseif ($_POST['entryOffline'.$x]=='3') {
        $owner = new Owner();
        $owner->id = $_POST['id'.$x];
        $owner->businessname = $_POST['businessname'.$x];
        $owner->firstname = $_POST['firstname'.$x];
        $owner->surname = $_POST['surname'.$x];
        $owner->email = $_POST['email'.$x];
        $owner->telephone = $_POST['telephone'.$x];
        $owner->update();
      }
    }
     //  redirect("index.php");
  }

 ?>

<body>
  <h1>Form</h1>
</body>

 <script type="text/javascript" src="js/idb.js"></script>
 <script type="text/javascript" src="js/main.js"></script>
 <script>
    idbApp.offlineEntriesObj().then(function(result){
      idbApp.postOfflineEntriesPromise(result);
    });
 </script>
