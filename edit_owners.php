<?php include("includes/init.php"); ?>

<?php

if(empty($_GET['id'])){
    redirect("index.php");
}

$owner = Owner::find_by_id($_GET['id']);

 if(isset($_POST['update'])){
  if($owner){
     $owner->businessname = $_POST['businessname'];
     $owner->firstname = $_POST['firstname'];
     $owner->surname = $_POST['surname'];
     $owner->email = $_POST['email'];
     $owner->telephone = $_POST['telephone'];
     $owner->update();
    redirect("index.php");
  } else{
    redirect("index.php");
  }
 }
 ?>


        <div id="page-wrapper">

          <div class="container-fluid">

              <!-- Page Heading -->
              <div class="row">
                  <div class="col-lg-12">
                      <h1 class="page-header">
                           EDIT OWNER
                      </h1>

              <form id="myFormEdit" action="" method="post" enctype="multipart/form-data">
                      <div class="col-md-6">
                        <div class="form-group">
                        <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $owner->id;?>">
                       </div>

                          <div class="form-group">
                          <label for="businessname">Business Name</label>
                          <input type="text"  id="businessname"  name="businessname" class="form-control" value="<?php echo $owner->businessname;?>">
                        </div>

                        <div class="form-group">
                          <label for="firstname">First Name</label>
                          <input type="text"   id="firstname" name="firstname" class="form-control" value="<?php echo  $owner->firstname;?>">
                        </div>

                        <div class="form-group">
                          <label for="surname">Surname</label>
                          <input type="text" id="surname" name="surname" class="form-control" value="<?php echo  $owner->surname;?>">
                        </div>

                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="text"  id="email" name="email" class="form-control" value="<?php echo  $owner->email;?>">
                        </div>

                        <div class="form-group">
                            <label for="telephone">Telephone Number</label>
                            <input type="telephone" id="telephone" name="telephone" class="form-control" value="<?php echo  $owner->telephone;?>">
                        </div>

                        <div class="form-group">
                        <input type="hidden" id="entryOffline" name="entryOffline" class="form-control">
                       </div>


                          <div class="update pull-right">
                              <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg" >
                         </div>
                      </div>
                    </form>
                </div>
              </div>
              <!-- /.row -->
          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
