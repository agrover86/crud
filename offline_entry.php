<?php include("includes/init.php"); ?>

<?php
$owner = new Owner();

 if(isset($_POST['create'])){
  if($owner){
     $owner->businessname = $_POST['businessname'];
     $owner->firstname = $_POST['firstname'];
     $owner->surname = $_POST['surname'];
     $owner->email = $_POST['email'];
     $owner->telephone = $_POST['telephone'];
     $owner->create();
     redirect("index.php");
    }


 }
 ?>
 <script type="text/javascript" src="js/idb.js"></script>
 <script type="text/javascript" src="js/main.js"></script>

        <div id="page-wrapper">
              <!-- Page Heading -->
              <div class="row">
                  <div class="col-lg-12">
              <form id="myForm" action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">
                          <input id="businessname" type="hidden" name="businessname" class="form-control" value="idbApp.offlineEntriesObject.businessname">
                          <input id="firstname" type="hidden" name="firstname" class="form-control" value="idbApp.offlineEntriesObject.firstname">
                          <input id="surname"  type="hidden" name="surname" class="form-control" value="idbApp.offlineEntriesObject.surname">
                          <input id="email" type="hidden" name="email" class="form-control" value="idbApp.offlineEntriesObject.email">
                          <input  id="telephone" type="hidden" name="telephone" class="form-control" value="idbApp.offlineEntriesObject.telephone">
                          <input type="submit" name="create" value="Create" class="btn btn-primary btn-lg">
                      </div>
                    </form>
                </div>
              </div>
              <!-- /.row -->
          <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
