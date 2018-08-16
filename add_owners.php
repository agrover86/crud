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

          <div class="container-fluid">

              <!-- Page Heading -->
              <div class="row">
                  <div class="col-lg-12">
                      <h1 class="page-header">
                        Add Owner
                      </h1>

              <form id="myForm" action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">

                        <div class="form-group">
                          <label for="businessname">Business Name</label>
                          <input id="businessname" type="text" name="businessname" class="form-control">
                        </div>

                        <div class="form-group">
                          <label for="firstname">First Name</label>
                          <input id="firstname" type="text" name="firstname" class="form-control">
                        </div>

                        <div class="form-group">
                          <label for="surname">Surname</label>
                          <input id="surname"  type="text" name="surname" class="form-control">
                        </div>

                        <div class="form-group">
                          <label for="email">Email</label>
                          <input  id="email" type="text" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="telephone">Telephone Number</label>
                            <input   id="telephone" type="telephone" name="telephone" class="form-control">
                        </div>
                        <input type="submit" name="create" value="Create" class="btn btn-primary btn-lg" onclick="idbApp.storePost();">
                      </div>
                    </form>
                </div>
              </div>
              <!-- /.row -->
          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
